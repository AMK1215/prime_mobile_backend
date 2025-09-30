import React from 'react';
import BannerSlider from '../components/BannerSlider';
import BannerText from '../components/BannerText';
import CategoriesSection from '../components/CategoriesSection';
import CategorySection from '../components/CategorySection';
import { ProductGrid } from '../components/ProductCard';
import { useProducts } from '../hooks/useProducts';
import { 
  Star, 
  TrendingUp, 
  Zap, 
  Award, 
  ArrowRight,
  Sparkles,
  Heart
} from 'lucide-react';

const HomePage = () => {
  const { products: featuredProducts, loading: featuredLoading } = useProducts('featured');
  const { products: latestProducts, loading: latestLoading } = useProducts('latest');

  // Fallback products if API fails
  const fallbackProducts = [
    {
      id: 1,
      name: 'iPhone 15 Pro',
      description: 'Latest iPhone with advanced camera system and titanium design',
      price: 999,
      image_url: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
      is_in_stock: true,
      quantity: 10,
      category: { name: 'Smartphones' },
      status: { name: 'Best Seller' }
    },
    {
      id: 2,
      name: 'Samsung Galaxy S24',
      description: 'Premium Android smartphone with AI features and stunning display',
      price: 899,
      image_url: 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
      is_in_stock: true,
      quantity: 8,
      category: { name: 'Smartphones' },
      status: { name: 'New Arrival' }
    },
    {
      id: 3,
      name: 'iPhone 14 Pro Max',
      description: 'Powerful iPhone with Pro camera system and all-day battery life',
      price: 1099,
      image_url: 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
      is_in_stock: true,
      quantity: 5,
      category: { name: 'Smartphones' },
      status: { name: 'On Sale' }
    },
    {
      id: 4,
      name: 'Samsung Galaxy Z Flip 5',
      description: 'Foldable smartphone with compact design and premium features',
      price: 999,
      image_url: 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
      is_in_stock: true,
      quantity: 12,
      category: { name: 'Smartphones' },
      status: { name: 'Limited Stock' }
    },
    {
      id: 5,
      name: 'Google Pixel 8 Pro',
      description: 'AI-powered smartphone with exceptional camera capabilities',
      price: 899,
      image_url: 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
      is_in_stock: true,
      quantity: 7,
      category: { name: 'Smartphones' },
      status: { name: 'Available' }
    },
    {
      id: 6,
      name: 'OnePlus 12',
      description: 'Flagship killer with blazing fast performance and premium build',
      price: 799,
      image_url: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
      is_in_stock: true,
      quantity: 15,
      category: { name: 'Smartphones' },
      status: { name: 'New Arrival' }
    }
  ];

  const displayFeaturedProducts = featuredProducts.length > 0 ? featuredProducts : fallbackProducts.slice(0, 4);
  const displayLatestProducts = latestProducts.length > 0 ? latestProducts : fallbackProducts.slice(2, 6);
  
  // Use fallback products if API is still loading after 5 seconds to prevent long loading states
  const useFallbackFeatured = featuredLoading && featuredProducts.length === 0;
  const useFallbackLatest = latestLoading && latestProducts.length === 0;


  return (
    <div className="min-h-screen">
      {/* Hero Section with Banner Slider */}
      <section className="relative">
        <BannerSlider />
        <BannerText />
      </section>

      {/* Categories Section */}
      <CategoriesSection />

      {/* Featured Products Section */}
      <section className="py-20 bg-gray-900">
        <div className="container-custom">
          <div className="text-center mb-16">
            <div className="inline-flex items-center space-x-2 bg-yellow-500/20 border border-yellow-500/30 text-yellow-400 px-6 py-3 rounded-full text-sm font-semibold mb-6">
              <Sparkles className="w-5 h-5" />
              <span>Featured Collection</span>
            </div>
            
            <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
              Featured Products
            </h2>
            <p className="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
              Discover our most popular smartphones with amazing features and unbeatable prices
            </p>
          </div>

          <ProductGrid 
            products={useFallbackFeatured ? fallbackProducts : displayFeaturedProducts} 
            loading={featuredLoading} 
          />

          <div className="text-center mt-12">
            <a
              href="/products?featured=true"
              className="bg-gradient-to-r from-yellow-500 to-yellow-600 text-gray-900 px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 inline-flex items-center space-x-2"
            >
              <span>View All Featured</span>
              <ArrowRight className="w-5 h-5" />
            </a>
          </div>
        </div>
      </section>

      {/* Categories Section */}
      <CategorySection />

      {/* Latest Products Section */}
      <section className="py-20 bg-gray-800">
        <div className="container-custom">
          <div className="text-center mb-16">
            <div className="inline-flex items-center space-x-2 bg-gray-700 border border-yellow-500/30 text-yellow-400 px-6 py-3 rounded-full text-sm font-semibold mb-6 shadow-lg">
              <Zap className="w-5 h-5" />
              <span>New Arrivals</span>
            </div>
            
            <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
              Latest Arrivals
            </h2>
            <p className="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
              Check out the newest additions to our collection with cutting-edge technology
            </p>
          </div>

          <ProductGrid 
            products={useFallbackLatest ? fallbackProducts : displayLatestProducts} 
            loading={latestLoading} 
          />

          <div className="text-center mt-12">
            <a
              href="/products?sort=newest"
              className="border border-yellow-500 text-yellow-400 hover:bg-yellow-500 hover:text-gray-900 px-8 py-4 rounded-xl font-semibold transition-all duration-300 inline-flex items-center space-x-2"
            >
              <span>Explore All New Arrivals</span>
              <ArrowRight className="w-5 h-5" />
            </a>
          </div>
        </div>
      </section>

      {/* Newsletter Section */}
      <section className="py-20 bg-gradient-to-r from-yellow-500 to-yellow-600 relative overflow-hidden">
        <div className="absolute inset-0 opacity-10">
          <div className="absolute inset-0" style={{
            backgroundImage: `url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3C/g%3E%3C/svg%3E")`,
          }}></div>
        </div>

        <div className="container-custom relative">
          <div className="max-w-3xl mx-auto text-center">
            <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
              Stay Updated with Latest Offers
            </h2>
            <p className="text-xl text-gray-800 mb-8 leading-relaxed">
              Subscribe to our newsletter and be the first to know about new products, exclusive deals, and special promotions.
            </p>
            
            <div className="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
              <input
                type="email"
                placeholder="Enter your email address"
                className="flex-1 px-6 py-4 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-gray-900/50 text-gray-800 placeholder-gray-500"
              />
              <button className="bg-gray-900 text-white hover:bg-gray-800 px-8 py-4 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 rounded-lg">
                Subscribe
              </button>
            </div>
            
            <p className="text-sm text-gray-700 mt-4">
              We respect your privacy. Unsubscribe at any time.
            </p>
          </div>
        </div>
      </section>
    </div>
  );
};

export default HomePage;