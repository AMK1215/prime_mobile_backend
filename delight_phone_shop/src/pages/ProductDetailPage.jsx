import React from 'react';
import { useParams, Link } from 'react-router-dom';
import { useProduct } from '../hooks/useProducts';
import { ArrowLeft, ShoppingCart, Heart, Share2, Star } from 'lucide-react';

const ProductDetailPage = () => {
  const { id } = useParams();
  const { product, loading, error } = useProduct(id);

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
          {/* Product Image */}
          <div className="space-y-4">
            <div className="aspect-square bg-white rounded-lg shadow-lg overflow-hidden">
              <img
                src={product.image_url || product.image || 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'}
                alt={product.name}
                className="w-full h-full object-cover"
              />
            </div>
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
            <h1 className="text-3xl font-bold text-gray-800">
              {product.name}
            </h1>

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
              <span className="text-gray-600">(4.0) • 128 reviews</span>
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
              {product.quantity <= 5 && product.quantity > 0 && (
                <span className="text-orange-600 text-sm">
                  (Only {product.quantity} left)
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

            {/* Features */}
            <div className="border-t pt-6">
              <h3 className="font-semibold text-gray-800 mb-4">Key Features</h3>
              <ul className="space-y-2 text-gray-600">
                <li>• High-resolution display</li>
                <li>• Long-lasting battery</li>
                <li>• Advanced camera system</li>
                <li>• Fast processor</li>
                <li>• 5G connectivity</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProductDetailPage;
