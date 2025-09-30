import React, { useState } from 'react';
import { ProductGrid } from '../components/ProductCard';
import { useProducts } from '../hooks/useProducts';
import { Search, Star, Crown, Award, Sparkles, TrendingUp } from 'lucide-react';

const FeaturedPage = () => {
  const [searchTerm, setSearchTerm] = useState('');
  const { products, loading, error, refetch } = useProducts('featured');

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
            <div className="bg-gradient-to-r from-yellow-500 to-yellow-600 p-3 rounded-xl">
              <Star className="w-8 h-8 text-gray-900" />
            </div>
            <div>
              <h1 className="text-3xl md:text-4xl font-bold text-white">
                Featured Collection
              </h1>
              <p className="text-gray-300 mt-1">
                Handpicked premium smartphones just for you
              </p>
            </div>
          </div>
          
          <div className="inline-flex items-center space-x-2 bg-yellow-500/20 border border-yellow-500/30 text-yellow-400 px-4 py-2 rounded-full text-sm font-semibold">
            <Sparkles className="w-4 h-4" />
            <span>Editor's Choice</span>
          </div>
        </div>

        {/* Search Bar */}
        <div className="bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
          <form onSubmit={handleSearch}>
            <div className="relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
              <input
                type="text"
                placeholder="Search featured products..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent placeholder-gray-400"
              />
            </div>
          </form>
        </div>

        {/* Featured Categories */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div className="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-gray-900">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-800 text-sm font-medium">Featured Products</p>
                <p className="text-3xl font-bold mt-1">{products.length}</p>
              </div>
              <Star className="w-12 h-12 text-gray-800" />
            </div>
          </div>
          
          <div className="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-400 text-sm font-medium">Premium Selection</p>
                <p className="text-3xl font-bold text-white mt-1">Top Rated</p>
              </div>
              <Crown className="w-12 h-12 text-yellow-500" />
            </div>
          </div>
          
          <div className="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-gray-400 text-sm font-medium">Special Picks</p>
                <p className="text-3xl font-bold text-white mt-1">Curated</p>
              </div>
              <Award className="w-12 h-12 text-blue-500" />
            </div>
          </div>
        </div>

        {/* Featured Highlights */}
        <div className="bg-gradient-to-r from-gray-800 to-gray-700 rounded-xl p-6 mb-8 border border-yellow-500/30">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div className="flex items-start space-x-3">
              <div className="bg-yellow-500/20 p-2 rounded-lg">
                <TrendingUp className="w-6 h-6 text-yellow-400" />
              </div>
              <div>
                <h3 className="text-white font-semibold mb-1">Trending Now</h3>
                <p className="text-gray-400 text-sm">Most popular phones this month</p>
              </div>
            </div>
            
            <div className="flex items-start space-x-3">
              <div className="bg-yellow-500/20 p-2 rounded-lg">
                <Crown className="w-6 h-6 text-yellow-400" />
              </div>
              <div>
                <h3 className="text-white font-semibold mb-1">Premium Quality</h3>
                <p className="text-gray-400 text-sm">Top-tier flagship devices</p>
              </div>
            </div>
            
            <div className="flex items-start space-x-3">
              <div className="bg-yellow-500/20 p-2 rounded-lg">
                <Award className="w-6 h-6 text-yellow-400" />
              </div>
              <div>
                <h3 className="text-white font-semibold mb-1">Award Winners</h3>
                <p className="text-gray-400 text-sm">Industry recognized devices</p>
              </div>
            </div>
          </div>
        </div>

        {/* Products */}
        {error ? (
          <div className="text-center py-12">
            <div className="w-24 h-24 mx-auto mb-4 bg-gray-800 rounded-full flex items-center justify-center">
              <Star className="w-12 h-12 text-gray-400" />
            </div>
            <h3 className="text-lg font-semibold text-white mb-2">Error Loading Featured Products</h3>
            <p className="text-gray-400 mb-4">{error}</p>
            <button onClick={refetch} className="bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-600 transition-colors">
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
              Showing {searchTerm ? filteredProducts.length : products.length} featured product{(searchTerm ? filteredProducts.length : products.length) !== 1 ? 's' : ''}
              {searchTerm && ` matching "${searchTerm}"`}
            </p>
          </div>
        )}

        {/* Why Featured Section */}
        <div className="mt-16 bg-gray-800 rounded-xl p-8 border border-gray-700">
          <h2 className="text-2xl font-bold text-white mb-6 text-center">Why Our Featured Collection?</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="flex items-start space-x-4">
              <div className="bg-yellow-500/20 p-3 rounded-lg flex-shrink-0">
                <Star className="w-6 h-6 text-yellow-400" />
              </div>
              <div>
                <h3 className="text-white font-semibold mb-2">Carefully Selected</h3>
                <p className="text-gray-400 text-sm">
                  Our team handpicks each featured product based on performance, customer reviews, and latest technology trends.
                </p>
              </div>
            </div>
            
            <div className="flex items-start space-x-4">
              <div className="bg-yellow-500/20 p-3 rounded-lg flex-shrink-0">
                <Crown className="w-6 h-6 text-yellow-400" />
              </div>
              <div>
                <h3 className="text-white font-semibold mb-2">Premium Quality</h3>
                <p className="text-gray-400 text-sm">
                  Only the best smartphones make it to our featured collection. Quality and performance guaranteed.
                </p>
              </div>
            </div>
            
            <div className="flex items-start space-x-4">
              <div className="bg-yellow-500/20 p-3 rounded-lg flex-shrink-0">
                <TrendingUp className="w-6 h-6 text-yellow-400" />
              </div>
              <div>
                <h3 className="text-white font-semibold mb-2">Market Leaders</h3>
                <p className="text-gray-400 text-sm">
                  These phones are leading the market in sales, features, and customer satisfaction.
                </p>
              </div>
            </div>
            
            <div className="flex items-start space-x-4">
              <div className="bg-yellow-500/20 p-3 rounded-lg flex-shrink-0">
                <Award className="w-6 h-6 text-yellow-400" />
              </div>
              <div>
                <h3 className="text-white font-semibold mb-2">Award Winning</h3>
                <p className="text-gray-400 text-sm">
                  Recognized by industry experts and tech reviewers for innovation and excellence.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default FeaturedPage;
