import React, { useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { useProduct } from '../hooks/useProducts';
import { ArrowLeft, ShoppingCart, Heart, Share2, Star, ChevronLeft, ChevronRight, X } from 'lucide-react';

const ProductDetailPage = () => {
  const { id } = useParams();
  const { product, loading, error } = useProduct(id);
  const [currentImageIndex, setCurrentImageIndex] = useState(0);
  const [showGallery, setShowGallery] = useState(false);

  // Helper function to construct proper image URL
  const getImageUrl = (imagePath) => {
    if (!imagePath) return 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
    
    // If it's already a full URL, return as is
    if (imagePath.startsWith('http')) return imagePath;
    
    // If it's a relative path, construct full URL
    if (imagePath.startsWith('/storage/')) {
      return `https://sales.primemobilemm.site${imagePath}`;
    }
    
    // If it's just a path without leading slash, add the base URL
    return `https://sales.primemobilemm.site/storage/${imagePath}`;
  };

  // Get current image to display
  const getCurrentImage = () => {
    if (product?.images && product.images.length > 0) {
      const image = product.images[currentImageIndex] || product.images[0];
      return {
        ...image,
        image_url: getImageUrl(image.image_path || image.image_url)
      };
    }
    return {
      image_url: getImageUrl(product?.image_url || product?.image)
    };
  };

  // Get primary image or first image
  const getPrimaryImage = () => {
    if (product?.images && product.images.length > 0) {
      const primaryImage = product.images.find(img => img.is_primary);
      const image = primaryImage || product.images[0];
      return {
        ...image,
        image_url: getImageUrl(image.image_path || image.image_url)
      };
    }
    return {
      image_url: getImageUrl(product?.image_url || product?.image)
    };
  };

  const handleImageNavigation = (direction) => {
    if (product?.images && product.images.length > 1) {
      if (direction === 'next') {
        setCurrentImageIndex((prev) => (prev + 1) % product.images.length);
      } else {
        setCurrentImageIndex((prev) => (prev - 1 + product.images.length) % product.images.length);
      }
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50">
        <div className="container mx-auto px-4 py-8">
          <div className="animate-pulse">
            <div className="h-8 bg-gray-200 rounded w-1/4 mb-4"></div>
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <div className="h-96 bg-gray-200 rounded-lg"></div>
              <div className="space-y-4">
                <div className="h-8 bg-gray-200 rounded w-3/4"></div>
                <div className="h-4 bg-gray-200 rounded w-1/2"></div>
                <div className="h-6 bg-gray-200 rounded w-1/3"></div>
                <div className="h-12 bg-gray-200 rounded"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }

  if (error || !product) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <h2 className="text-2xl font-bold text-gray-800 mb-4">Product Not Found</h2>
          <p className="text-gray-600 mb-6">{error || 'The product you are looking for does not exist.'}</p>
          <Link to="/products" className="btn btn-primary">
            Browse Products
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="container mx-auto px-4 py-8">
        {/* Back Button */}
        <Link 
          to="/products" 
          className="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6"
        >
          <ArrowLeft className="w-4 h-4 mr-2" />
          Back to Products
        </Link>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
          {/* Product Images */}
          <div className="space-y-4">
            {/* Main Image */}
            <div className="relative aspect-square bg-white rounded-lg shadow-lg overflow-hidden group cursor-pointer" onClick={() => setShowGallery(true)}>
              <img
                src={getCurrentImage().image_url}
                alt={product.name}
                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              />
              
              {/* Image Navigation Arrows - Only show if multiple images */}
              {product.images && product.images.length > 1 && (
                <>
                  <button
                    onClick={(e) => {
                      e.stopPropagation();
                      handleImageNavigation('prev');
                    }}
                    className="absolute left-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-black/50 hover:bg-black/70 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300"
                    aria-label="Previous image"
                  >
                    <ChevronLeft className="w-5 h-5" />
                  </button>
                  <button
                    onClick={(e) => {
                      e.stopPropagation();
                      handleImageNavigation('next');
                    }}
                    className="absolute right-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-black/50 hover:bg-black/70 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300"
                    aria-label="Next image"
                  >
                    <ChevronRight className="w-5 h-5" />
                  </button>
                </>
              )}

              {/* Image Counter - Show if multiple images */}
              {product.images && product.images.length > 1 && (
                <div className="absolute top-4 right-4 bg-black/70 text-white px-3 py-1 rounded-full text-sm font-medium">
                  {currentImageIndex + 1} / {product.images.length}
                </div>
              )}

              {/* Gallery Icon - Show if multiple images */}
              {product.images && product.images.length > 1 && (
                <div className="absolute bottom-4 right-4 bg-black/70 text-white px-3 py-1 rounded-full text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                  Click to view gallery
                </div>
              )}
            </div>

            {/* Thumbnail Strip - Show if multiple images */}
            {product.images && product.images.length > 1 && (
              <div className="flex space-x-2 overflow-x-auto pb-2">
                {product.images.map((image, index) => (
                  <button
                    key={image.id || index}
                    onClick={() => setCurrentImageIndex(index)}
                    className={`flex-shrink-0 w-20 h-20 rounded-lg border-2 transition-all ${
                      currentImageIndex === index
                        ? 'border-blue-500 scale-105'
                        : 'border-gray-200 hover:border-gray-400'
                    }`}
                  >
                    <img
                      src={getImageUrl(image.image_path || image.image_url)}
                      alt={`${product.name} - Image ${index + 1}`}
                      className="w-full h-full object-cover rounded-lg"
                    />
                  </button>
                ))}
              </div>
            )}
          </div>

          {/* Product Info */}
          <div className="space-y-6">
            {/* Category */}
            {product.category && (
              <div className="text-sm text-gray-500">
                {product.category.name}
              </div>
            )}

            {/* Title */}
            <div className="flex items-center space-x-4 mb-2">
              <h1 className="text-3xl font-bold text-gray-800">
                {product.name}
              </h1>
              {product.status && (
                <span className={`px-3 py-1 rounded-full text-sm font-medium ${
                  product.status.name === 'New Arrival' ? 'bg-green-100 text-green-800' :
                  product.status.name === 'Best Seller' ? 'bg-red-100 text-red-800' :
                  product.status.name === 'On Sale' ? 'bg-orange-100 text-orange-800' :
                  product.status.name === 'Available' ? 'bg-blue-100 text-blue-800' :
                  'bg-gray-100 text-gray-800'
                }`}>
                  {product.status.name}
                </span>
              )}
            </div>

            {/* Rating */}
            <div className="flex items-center space-x-2">
              <div className="flex items-center">
                {[1, 2, 3, 4, 5].map((star) => (
                  <Star
                    key={star}
                    className={`w-5 h-5 ${
                      star <= 4 
                        ? 'text-yellow-400 fill-current' 
                        : 'text-gray-300'
                    }`}
                  />
                ))}
              </div>
              <span className="text-gray-600">(4.2) • {product.customers_count || 0} sales</span>
            </div>

            {/* Price */}
            <div className="text-3xl font-bold text-gray-800">
              {product.formatted_price || `$${product.price}`}
            </div>

            {/* Description */}
            <div className="text-gray-600 leading-relaxed">
              {product.description}
            </div>

            {/* Stock Status */}
            <div className="flex items-center space-x-2">
              {product.is_in_stock ? (
                <span className="text-green-600 font-medium">✓ In Stock</span>
              ) : (
                <span className="text-red-600 font-medium">✗ Out of Stock</span>
              )}
              {product.quantity && product.quantity <= 5 && product.quantity > 0 && (
                <span className="text-orange-600 text-sm">
                  (Only {product.quantity} left)
                </span>
              )}
              {product.quantity && product.quantity > 5 && (
                <span className="text-green-600 text-sm">
                  ({product.quantity} available)
                </span>
              )}
            </div>

            {/* Actions */}
            <div className="space-y-4">
              <div className="flex space-x-4">
                <button 
                  disabled={!product.is_in_stock}
                  className={`flex-1 btn ${product.is_in_stock ? 'btn-primary' : 'btn-secondary'} py-3 flex items-center justify-center space-x-2`}
                >
                  <ShoppingCart className="w-5 h-5" />
                  <span>{product.is_in_stock ? 'Add to Cart' : 'Out of Stock'}</span>
                </button>
                
                <button className="btn btn-outline py-3 px-4">
                  <Heart className="w-5 h-5" />
                </button>
                
                <button className="btn btn-outline py-3 px-4">
                  <Share2 className="w-5 h-5" />
                </button>
              </div>
            </div>

            {/* Phone Specifications */}
            {(product.ram || product.storage || product.screen_size || product.color || product.battery_capacity || product.battery_watt) && (
              <div className="border-t pt-6">
                <h3 className="font-semibold text-gray-800 mb-4">Phone Specifications</h3>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  {product.ram && (
                    <div className="flex justify-between">
                      <span className="text-gray-600">RAM:</span>
                      <span className="font-medium text-gray-800">{product.ram}</span>
                    </div>
                  )}
                  {product.storage && (
                    <div className="flex justify-between">
                      <span className="text-gray-600">Storage:</span>
                      <span className="font-medium text-gray-800">{product.storage}</span>
                    </div>
                  )}
                  {product.screen_size && (
                    <div className="flex justify-between">
                      <span className="text-gray-600">Screen Size:</span>
                      <span className="font-medium text-gray-800">{product.screen_size}</span>
                    </div>
                  )}
                  {product.color && (
                    <div className="flex justify-between">
                      <span className="text-gray-600">Color:</span>
                      <span className="font-medium text-gray-800">{product.color}</span>
                    </div>
                  )}
                  {product.battery_capacity && (
                    <div className="flex justify-between">
                      <span className="text-gray-600">Battery Capacity:</span>
                      <span className="font-medium text-gray-800">{product.battery_capacity}</span>
                    </div>
                  )}
                  {product.battery_watt && (
                    <div className="flex justify-between">
                      <span className="text-gray-600">Battery Watt:</span>
                      <span className="font-medium text-gray-800">{product.battery_watt}</span>
                    </div>
                  )}
                </div>
              </div>
            )}

            {/* Product Information */}
            <div className="border-t pt-6">
              <h3 className="font-semibold text-gray-800 mb-4">Product Information</h3>
              <ul className="space-y-2 text-gray-600">
                <li>• Category: {product.category?.name || 'N/A'}</li>
                <li>• Status: {product.status?.name || 'N/A'}</li>
                <li>• Stock: {product.quantity || 0} units available</li>
                <li>• Price: {product.formatted_price || `$${product.price}`}</li>
                <li>• Total Sales: {product.customers_count || 0} units sold</li>
                {product.created_at && (
                  <li>• Added: {new Date(product.created_at).toLocaleDateString()}</li>
                )}
              </ul>
            </div>
          </div>
        </div>

        {/* Full-Screen Gallery Modal */}
        {showGallery && product?.images && product.images.length > 0 && (
          <div className="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4">
            <div className="relative w-full h-full max-w-6xl max-h-full flex flex-col">
              {/* Close Button */}
              <button
                onClick={() => setShowGallery(false)}
                className="absolute top-4 right-4 z-10 w-10 h-10 bg-white/20 hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-colors"
              >
                <X className="w-6 h-6" />
              </button>

              {/* Main Image */}
              <div className="flex-1 flex items-center justify-center relative">
                <img
                  src={getImageUrl(product.images[currentImageIndex]?.image_path || product.images[currentImageIndex]?.image_url)}
                  alt={`${product.name} - Image ${currentImageIndex + 1}`}
                  className="max-w-full max-h-full object-contain"
                />

                {/* Navigation Arrows */}
                {product.images.length > 1 && (
                  <>
                    <button
                      onClick={() => handleImageNavigation('prev')}
                      className="absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-colors"
                    >
                      <ChevronLeft className="w-6 h-6" />
                    </button>
                    <button
                      onClick={() => handleImageNavigation('next')}
                      className="absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-colors"
                    >
                      <ChevronRight className="w-6 h-6" />
                    </button>
                  </>
                )}
              </div>

              {/* Image Counter */}
              <div className="absolute top-4 left-4 bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium">
                {currentImageIndex + 1} / {product.images.length}
              </div>

              {/* Thumbnail Strip */}
              {product.images.length > 1 && (
                <div className="flex justify-center space-x-2 py-4 overflow-x-auto">
                  {product.images.map((image, index) => (
                    <button
                      key={image.id || index}
                      onClick={() => setCurrentImageIndex(index)}
                      className={`flex-shrink-0 w-16 h-16 rounded-lg border-2 transition-all ${
                        currentImageIndex === index
                          ? 'border-white scale-110'
                          : 'border-white/50 hover:border-white/80'
                      }`}
                    >
                      <img
                        src={getImageUrl(image.image_path || image.image_url)}
                        alt={`${product.name} - Image ${index + 1}`}
                        className="w-full h-full object-cover rounded-lg"
                      />
                    </button>
                  ))}
                </div>
              )}
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default ProductDetailPage;
