import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { ProductGrid } from '../components/ProductCard';
import { useProducts } from '../hooks/useProducts';
import { Search, Smartphone, Apple, ShoppingBag } from 'lucide-react';

const CategoryPage = () => {
  const { categorySlug } = useParams();
  const [searchTerm, setSearchTerm] = useState('');
  
  // Map slugs to category IDs
  const categoryMap = {
    'ios-phones': { id: 4, name: 'iOS Phones', icon: Apple, color: 'blue' },
    'android-phones': { id: 3, name: 'Android Phones', icon: Smartphone, color: 'green' },
    'accessories': { id: 5, name: 'Phone Accessories', icon: ShoppingBag, color: 'purple' }
  };

  const currentCategory = categoryMap[categorySlug] || { id: null, name: 'Category', icon: Smartphone, color: 'gray' };
  const CategoryIcon = currentCategory.icon;

  const { products, loading, error, refetch } = useProducts('category', {
    categoryId: currentCategory.id
  });

  const handleSearch = (e) => {
    e.preventDefault();
  };

  // Filter products based on search term
  const filteredProducts = products.filter(product => 
    product.name?.toLowerCase().includes(searchTerm.toLowerCase()) ||
    product.description?.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const colorClasses = {
    blue: {
      gradient: 'from-blue-500 to-blue-600',
      bg: 'bg-blue-500/20',
      border: 'border-blue-500/30',
      text: 'text-blue-400',
      hover: 'hover:bg-blue-600',
      ring: 'focus:ring-blue-500'
    },
    green: {
      gradient: 'from-green-500 to-green-600',
      bg: 'bg-green-500/20',
      border: 'border-green-500/30',
      text: 'text-green-400',
      hover: 'hover:bg-green-600',
      ring: 'focus:ring-green-500'
    },
    purple: {
      gradient: 'from-purple-500 to-purple-600',
      bg: 'bg-purple-500/20',
      border: 'border-purple-500/30',
      text: 'text-purple-400',
      hover: 'hover:bg-purple-600',
      ring: 'focus:ring-purple-500'
    }
  };

  const colors = colorClasses[currentCategory.color] || colorClasses.gray;

  return (
    <div className="min-h-screen bg-gray-900">
      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Header */}
        <div className="mb-8">
          <div className="flex items-center space-x-3 mb-4">
            <div className={`bg-gradient-to-r ${colors.gradient} p-3 rounded-xl`}>
              <CategoryIcon className="w-8 h-8 text-white" />
            </div>
            <div>
              <h1 className="text-3xl md:text-4xl font-bold text-white">
                {currentCategory.name}
              </h1>
              <p className="text-gray-300 mt-1">
                Explore our collection of {currentCategory.name.toLowerCase()}
              </p>
            </div>
          </div>
          
          <div className={`inline-flex items-center space-x-2 ${colors.bg} border ${colors.border} ${colors.text} px-4 py-2 rounded-full text-sm font-semibold`}>
            <CategoryIcon className="w-4 h-4" />
            <span>Premium Quality</span>
          </div>
        </div>

        {/* Search Bar */}
        <div className="bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
          <form onSubmit={handleSearch}>
            <div className="relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
              <input
                type="text"
                placeholder={`Search ${currentCategory.name.toLowerCase()}...`}
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className={`w-full pl-10 pr-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 ${colors.ring} focus:border-transparent placeholder-gray-400`}
              />
            </div>
          </form>
        </div>

        {/* Stats */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div className={`bg-gradient-to-br ${colors.gradient} rounded-xl p-6 text-white`}>
            <div className="flex items-center justify-between">
              <div>
                <p className="text-white/80 text-sm font-medium">Total Products</p>
                <p className="text-3xl font-bold mt-1">{products.length}</p>
              </div>
              <CategoryIcon className="w-12 h-12 text-white/50" />
            </div>
          </div>
          
          <div className="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-400 text-sm font-medium">In Stock</p>
                <p className="text-3xl font-bold text-white mt-1">
                  {products.filter(p => p.is_in_stock).length}
                </p>
              </div>
              <div className="text-4xl">📦</div>
            </div>
          </div>
          
          <div className="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-400 text-sm font-medium">Avg Price</p>
                <p className="text-3xl font-bold text-white mt-1">
                  ${products.length > 0 ? Math.round(products.reduce((sum, p) => sum + (p.price || 0), 0) / products.length) : 0}
                </p>
              </div>
              <div className="text-4xl">💰</div>
            </div>
          </div>
        </div>

        {/* Products */}
        {error ? (
          <div className="text-center py-12">
            <div className="w-24 h-24 mx-auto mb-4 bg-gray-800 rounded-full flex items-center justify-center">
              <CategoryIcon className="w-12 h-12 text-gray-400" />
            </div>
            <h3 className="text-lg font-semibold text-white mb-2">Error Loading Products</h3>
            <p className="text-gray-400 mb-4">{error}</p>
            <button onClick={refetch} className={`bg-gradient-to-r ${colors.gradient} text-white px-6 py-3 rounded-lg font-semibold ${colors.hover} transition-colors`}>
              Try Again
            </button>
          </div>
        ) : (
          <ProductGrid products={searchTerm ? filteredProducts : products} loading={loading} />
        )}

        {/* Results Count */}
        {!loading && !error && (
          <div className="mt-8 text-center text-gray-400">
            <p>
              Showing {searchTerm ? filteredProducts.length : products.length} product{(searchTerm ? filteredProducts.length : products.length) !== 1 ? 's' : ''}
              {searchTerm && ` matching "${searchTerm}"`}
            </p>
          </div>
        )}
      </div>
    </div>
  );
};

export default CategoryPage;
