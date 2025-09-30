import React, { useState } from 'react';
import { useSearchParams } from 'react-router-dom';
import { ProductGrid } from '../components/ProductCard';
import { useProducts } from '../hooks/useProducts';
import { Search, Filter, Grid, List } from 'lucide-react';

const ProductsPage = () => {
  const [searchParams, setSearchParams] = useSearchParams();
  const [searchTerm, setSearchTerm] = useState(searchParams.get('search') || '');
  const [sortBy, setSortBy] = useState(searchParams.get('sort') || 'newest');
  const [viewMode, setViewMode] = useState('grid');

  // Update search term when URL changes
  React.useEffect(() => {
    const urlSearch = searchParams.get('search');
    if (urlSearch && urlSearch !== searchTerm) {
      setSearchTerm(urlSearch);
    }
  }, [searchParams]);

  const options = {
    search: searchTerm,
    sort: sortBy,
    category_id: searchParams.get('category'),
    status_id: searchParams.get('status'),
  };

  const { products, loading, error, refetch } = useProducts('all', options);

  const handleSearch = (e) => {
    e.preventDefault();
    refetch();
  };

  // Debug logging
  React.useEffect(() => {
    console.log('ProductsPage - Products:', products);
    console.log('ProductsPage - Loading:', loading);
    console.log('ProductsPage - Error:', error);
  }, [products, loading, error]);

  return (
    <div className="min-h-screen bg-gray-900">
      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Header */}
        <div className="mb-8">
          <h1 className="text-3xl md:text-4xl font-bold text-white mb-4">
            All Products
          </h1>
          <p className="text-gray-300">
            Discover our complete collection of smartphones and accessories
          </p>
        </div>

        {/* Search and Filters */}
        <div className="bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
          <div className="flex flex-col lg:flex-row gap-4">
            {/* Search */}
            <form onSubmit={handleSearch} className="flex-1">
              <div className="relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                <input
                  type="text"
                  placeholder="Search products..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="w-full pl-10 pr-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent placeholder-gray-400"
                />
              </div>
            </form>

            {/* Sort */}
            <div className="flex gap-4">
              <select
                value={sortBy}
                onChange={(e) => setSortBy(e.target.value)}
                className="px-4 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
              >
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
                <option value="name">Name A-Z</option>
              </select>

              {/* View Mode */}
              <div className="flex border border-gray-600 rounded-lg overflow-hidden">
                <button
                  onClick={() => setViewMode('grid')}
                  className={`p-3 transition-colors ${viewMode === 'grid' ? 'bg-yellow-500 text-gray-900' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'}`}
                >
                  <Grid className="w-5 h-5" />
                </button>
                <button
                  onClick={() => setViewMode('list')}
                  className={`p-3 transition-colors ${viewMode === 'list' ? 'bg-yellow-500 text-gray-900' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'}`}
                >
                  <List className="w-5 h-5" />
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Products */}
        {error ? (
          <div className="text-center py-12">
            <div className="w-24 h-24 mx-auto mb-4 bg-gray-800 rounded-full flex items-center justify-center">
              <Search className="w-12 h-12 text-gray-400" />
            </div>
            <h3 className="text-lg font-semibold text-white mb-2">Error Loading Products</h3>
            <p className="text-gray-400 mb-4">{error}</p>
            <button onClick={refetch} className="bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition-colors">
              Try Again
            </button>
          </div>
        ) : (
          <ProductGrid products={products} loading={loading} />
        )}

        {/* Results Count */}
        {!loading && !error && (
          <div className="mt-8 text-center">
            <p className="text-gray-400">
              Showing <span className="text-white font-semibold">{products.length}</span> product{products.length !== 1 ? 's' : ''}
              {searchTerm && (
                <span className="text-yellow-400"> for "<span className="font-semibold">{searchTerm}</span>"</span>
              )}
            </p>
            {products.length === 0 && searchTerm && (
              <p className="text-gray-500 mt-2 text-sm">
                Try different keywords or <button onClick={() => setSearchTerm('')} className="text-yellow-400 hover:underline">clear search</button>
              </p>
            )}
          </div>
        )}
      </div>
    </div>
  );
};

export default ProductsPage;
