import React, { useState } from 'react';
import { ProductGrid } from '../components/ProductCard';
import { useProducts } from '../hooks/useProducts';
import { Search, Sparkles, Zap, Package } from 'lucide-react';

const NewArrivalsPage = () => {
  const [searchTerm, setSearchTerm] = useState('');
  const { products, loading, error, refetch } = useProducts('new-arrivals');

  const handleSearch = (e) => {
    e.preventDefault();
    // Filter products locally based on search
  };

  // Filter products based on search term
  const filteredProducts = products.filter(product => 
    product.name?.toLowerCase().includes(searchTerm.toLowerCase()) ||
    product.description?.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div className="min-h-screen bg-gray-900">
      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Header */}
        <div className="mb-8">
          <div className="flex items-center space-x-3 mb-4">
            <div className="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl">
              <Sparkles className="w-8 h-8 text-white" />
            </div>
            <div>
              <h1 className="text-3xl md:text-4xl font-bold text-white">
                New Arrivals
              </h1>
              <p className="text-gray-300 mt-1">
                Latest smartphones with cutting-edge technology
              </p>
            </div>
          </div>
          
          <div className="inline-flex items-center space-x-2 bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-2 rounded-full text-sm font-semibold">
            <Zap className="w-4 h-4" />
            <span>Just Launched</span>
          </div>
        </div>

        {/* Search Bar */}
        <div className="bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
          <form onSubmit={handleSearch}>
            <div className="relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
              <input
                type="text"
                placeholder="Search new arrivals..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent placeholder-gray-400"
              />
            </div>
          </form>
        </div>

        {/* Stats */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div className="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-green-100 text-sm font-medium">New This Month</p>
                <p className="text-3xl font-bold mt-1">{products.length}</p>
              </div>
              <Sparkles className="w-12 h-12 text-green-200" />
            </div>
          </div>
          
          <div className="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-400 text-sm font-medium">All In Stock</p>
                <p className="text-3xl font-bold text-white mt-1">100%</p>
              </div>
              <Package className="w-12 h-12 text-blue-500" />
            </div>
          </div>
          
          <div className="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-400 text-sm font-medium">Latest Tech</p>
                <p className="text-3xl font-bold text-white mt-1">2024</p>
              </div>
              <Zap className="w-12 h-12 text-yellow-500" />
            </div>
          </div>
        </div>

        {/* Products */}
        {error ? (
          <div className="text-center py-12">
            <div className="w-24 h-24 mx-auto mb-4 bg-gray-800 rounded-full flex items-center justify-center">
              <Sparkles className="w-12 h-12 text-gray-400" />
            </div>
            <h3 className="text-lg font-semibold text-white mb-2">Error Loading New Arrivals</h3>
            <p className="text-gray-400 mb-4">{error}</p>
            <button onClick={refetch} className="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors">
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
              Showing {searchTerm ? filteredProducts.length : products.length} new arrival{(searchTerm ? filteredProducts.length : products.length) !== 1 ? 's' : ''}
              {searchTerm && ` matching "${searchTerm}"`}
            </p>
          </div>
        )}
      </div>
    </div>
  );
};

export default NewArrivalsPage;
