import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import { 
  Heart, 
  ShoppingCart, 
  Eye, 
  Star, 
  Tag,
  Battery,
  Camera,
  Wifi,
  TrendingUp,
  Zap,
  Crown,
  Gamepad2,
  Gem,
  Sparkles,
  CheckCircle,
  Shield,
  Award
} from 'lucide-react';

const ProductCard = ({ product }) => {
  const [isLiked, setIsLiked] = useState(false);
  const [imageLoaded, setImageLoaded] = useState(false);
  const [imageError, setImageError] = useState(false);
  const [showQuickView, setShowQuickView] = useState(false);

  // Add safety check for product
  if (!product) {
    return (
      <div className="bg-white rounded-2xl shadow-lg overflow-hidden animate-pulse">
        <div className="h-64 bg-gray-200"></div>
        <div className="p-6 space-y-4">
          <div className="h-4 bg-gray-200 rounded w-3/4"></div>
          <div className="h-4 bg-gray-200 rounded w-1/2"></div>
          <div className="h-6 bg-gray-200 rounded w-1/3"></div>
        </div>
      </div>
    );
  }

  const handleLike = (e) => {
    e.preventDefault();
    e.stopPropagation();
    setIsLiked(!isLiked);
  };

  const handleAddToCart = (e) => {
    e.preventDefault();
    e.stopPropagation();
    console.log('Added to cart:', product);
  };

  const handleQuickView = (e) => {
    e.preventDefault();
    e.stopPropagation();
    setShowQuickView(!showQuickView);
  };

  const formatPrice = (price) => {
    if (!price) return '$0';
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 0,
      maximumFractionDigits: 0,
    }).format(price);
  };

  const getStatusBadge = (status) => {
    if (!status) return { color: 'bg-gray-500', text: 'N/A', icon: Tag };
    
    const statusMap = {
      'New Arrival': { color: 'bg-green-500', text: 'NEW', icon: Sparkles },
      'Best Seller': { color: 'bg-red-500', text: 'HOT', icon: TrendingUp },
      'On Sale': { color: 'bg-orange-500', text: 'SALE', icon: Tag },
      'Limited Stock': { color: 'bg-yellow-500', text: 'LIMITED', icon: Zap },
      'Available': { color: 'bg-blue-500', text: 'AVAILABLE', icon: CheckCircle },
      'Premium': { color: 'bg-purple-500', text: 'PREMIUM', icon: Crown },
    };
    
    return statusMap[status] || { color: 'bg-gray-500', text: status, icon: Tag };
  };

  const statusBadge = getStatusBadge(product.status?.name);
  const StatusIcon = statusBadge.icon;

  // Generate random rating for demo
  const rating = Math.round((Math.random() * 2 + 3) * 10) / 10; // 3.0 to 5.0
  const reviewCount = Math.floor(Math.random() * 200) + 10;

  return (
    <div className="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-yellow-200 transform hover:-translate-y-1">
      <Link to={`/products/${product.id}`} className="block">
        {/* Product Image Container */}
        <div className="relative h-64 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
          {!imageLoaded && !imageError && (
            <div className="absolute inset-0 bg-gray-200 animate-pulse flex items-center justify-center">
              <div className="w-8 h-8 border-2 border-yellow-500 border-t-transparent rounded-full animate-spin"></div>
            </div>
          )}
          
          <img
            src={product.image_url || (product.image ? `https://sales.primemobilemm.site/api/${product.image}` : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80')}
            alt={product.name}
            className={`w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ${
              imageLoaded ? 'opacity-100' : 'opacity-0'
            }`}
            onLoad={() => {
              setImageLoaded(true);
              setImageError(false);
            }}
            onError={(e) => {
              console.error('Image failed to load for product:', product.name);
              console.error('Attempted URL:', product.image_url || product.image);
              setImageError(true);
              setImageLoaded(true);
              // Set fallback image on error
              e.target.src = 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
            }}
            loading="lazy"
          />

          {/* Status Badge - Top Left */}
          {product.status && (
            <div className={`absolute top-3 left-3 ${statusBadge.color} text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center shadow-lg`}>
              <StatusIcon className="w-3 h-3 mr-1" />
              {statusBadge.text}
            </div>
          )}

          {/* Premium Badge for high-end products */}
          {product.price && product.price > 1000 && (
            <div className="absolute top-3 right-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center shadow-lg">
              <Gem className="w-3 h-3 mr-1" />
              PREMIUM
            </div>
          )}

          {/* Action Buttons - Top Right */}
          <div className="absolute top-3 right-3 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
            <button
              onClick={handleLike}
              className={`w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all backdrop-blur-sm ${
                isLiked 
                  ? 'bg-red-500 text-white shadow-red-500/50' 
                  : 'bg-white/90 text-gray-600 hover:bg-red-500 hover:text-white'
              }`}
              aria-label={isLiked ? 'Remove from favorites' : 'Add to favorites'}
            >
              <Heart className={`w-5 h-5 ${isLiked ? 'fill-current' : ''}`} />
            </button>
            
            <button
              onClick={handleQuickView}
              className="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg text-gray-600 hover:bg-blue-500 hover:text-white transition-all"
              aria-label="Quick view"
            >
              <Eye className="w-5 h-5" />
            </button>
          </div>

          {/* Stock Status Overlay */}
          {product.is_in_stock === false && (
            <div className="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center">
              <span className="bg-red-500 text-white px-6 py-3 rounded-xl font-semibold shadow-lg">
                Out of Stock
              </span>
            </div>
          )}
        </div>

        {/* Product Information */}
        <div className="p-6 bg-gradient-to-br from-gray-800 to-gray-900">
          {/* Category */}
          {product.category && (
            <div className="text-xs text-yellow-400 mb-2 font-medium flex items-center">
              <Crown className="w-3 h-3 mr-1" />
              {product.category.name}
            </div>
          )}

          {/* Product Name */}
          <h3 className="text-lg font-bold text-white mb-2 line-clamp-2 group-hover:text-yellow-300 transition-colors duration-200">
            {product.name || 'Product Name'}
          </h3>

          {/* Product Description */}
          <p className="text-sm text-gray-300 mb-4 line-clamp-2 leading-relaxed">
            {product.description || 'Latest flagship phone with premium features, cutting-edge technology, and exceptional performance for the modern user.'}
          </p>

          {/* Key Features */}
          <div className="flex items-center justify-between mb-4 text-xs text-gray-400">
            <div className="flex items-center space-x-1">
              <Battery className="w-4 h-4 text-green-400" />
              <span>Long Battery</span>
            </div>
            <div className="flex items-center space-x-1">
              <Camera className="w-4 h-4 text-blue-400" />
              <span>High Res</span>
            </div>
            <div className="flex items-center space-x-1">
              <Wifi className="w-4 h-4 text-purple-400" />
              <span>5G Ready</span>
            </div>
          </div>

          {/* Rating and Reviews */}
          <div className="flex items-center mb-4">
            <div className="flex items-center space-x-1">
              {[1, 2, 3, 4, 5].map((star) => (
                <Star
                  key={star}
                  className={`w-4 h-4 ${
                    star <= Math.floor(rating)
                      ? 'text-yellow-400 fill-current' 
                      : 'text-gray-600'
                  }`}
                />
              ))}
            </div>
            <span className="text-sm text-white ml-2 font-semibold">{rating}</span>
            <span className="text-sm text-gray-400 ml-2">• {reviewCount} reviews</span>
          </div>

          {/* Price and Add to Cart */}
          <div className="flex items-center justify-between">
            <div className="flex flex-col">
              <span className="text-2xl font-bold text-white">
                {formatPrice(product.price)}
              </span>
              {product.quantity && product.quantity <= 5 && product.quantity > 0 && (
                <span className="text-xs text-yellow-400 font-medium flex items-center mt-1">
                  <Zap className="w-3 h-3 mr-1" />
                  Only {product.quantity} left!
                </span>
              )}
            </div>

            <button
              onClick={handleAddToCart}
              disabled={product.is_in_stock === false}
              className={`flex items-center space-x-2 px-4 py-3 rounded-xl font-semibold transition-all shadow-lg ${
                product.is_in_stock !== false
                  ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-gray-900 hover:from-yellow-400 hover:to-yellow-500 transform hover:-translate-y-0.5 hover:shadow-xl'
                  : 'bg-gray-600 text-gray-400 cursor-not-allowed'
              }`}
            >
              <ShoppingCart className="w-5 h-5" />
              <span className="hidden sm:inline">
                {product.is_in_stock !== false ? 'Add to Cart' : 'Out of Stock'}
              </span>
            </button>
          </div>

          {/* Trust Badges */}
          <div className="flex items-center justify-center mt-4 pt-4 border-t border-gray-700">
            <div className="flex items-center space-x-4 text-xs text-gray-400">
              <div className="flex items-center space-x-1">
                <Shield className="w-3 h-3 text-green-400" />
                <span>1 Year Warranty</span>
              </div>
              <div className="flex items-center space-x-1">
                <Award className="w-3 h-3 text-blue-400" />
                <span>Premium Quality</span>
              </div>
            </div>
          </div>
        </div>
      </Link>
    </div>
  );
};

// Enhanced Product Grid Component
export const ProductGrid = ({ products, loading = false }) => {
  if (loading) {
    return (
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {[...Array(8)].map((_, index) => (
          <div key={index} className="bg-white rounded-2xl shadow-lg overflow-hidden animate-pulse">
            <div className="h-64 bg-gray-200"></div>
            <div className="p-6 space-y-4">
              <div className="h-4 bg-gray-200 rounded w-3/4"></div>
              <div className="h-4 bg-gray-200 rounded w-1/2"></div>
              <div className="h-6 bg-gray-200 rounded w-1/3"></div>
            </div>
          </div>
        ))}
      </div>
    );
  }

  if (!products || products.length === 0) {
    return (
      <div className="text-center py-16">
        <div className="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center">
          <ShoppingCart className="w-12 h-12 text-white" />
        </div>
        <h3 className="text-2xl font-bold text-white mb-3">No Products Found</h3>
        <p className="text-gray-300 mb-8 max-w-md mx-auto">
          We couldn't find any products matching your criteria. Try adjusting your search or browse our categories.
        </p>
        <button className="bg-gradient-to-r from-yellow-500 to-yellow-600 text-gray-900 px-8 py-3 rounded-xl font-semibold hover:from-yellow-400 hover:to-yellow-500 transition-all transform hover:-translate-y-0.5 shadow-lg">
          Browse All Products
        </button>
      </div>
    );
  }

  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      {products.map((product) => (
        <ProductCard key={product?.id || Math.random()} product={product} />
      ))}
    </div>
  );
};

export default ProductCard;