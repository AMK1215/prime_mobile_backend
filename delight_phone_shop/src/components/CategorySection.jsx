import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { 
  Smartphone, 
  Laptop, 
  Headphones, 
  Battery, 
  Camera, 
  Shield,
  ArrowRight,
  TrendingUp,
  Star,
  Zap,
  Crown,
  Gamepad2
} from 'lucide-react';
import { apiService } from '../services/api';

const CategorySection = () => {
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchCategories();
  }, []);

  const fetchCategories = async () => {
    try {
      setLoading(true);
      const response = await apiService.getCategories();
      
      if (response.data.status === 'Request was successful.' && response.data.data) {
        setCategories(response.data.data);
      } else {
        // Fallback categories with gaming style
        setCategories([
          {
            id: 1,
            name: 'Smartphones',
            description: 'Latest mobile phones from top brands',
            products_count: 25,
            icon: 'smartphone'
          },
          {
            id: 2,
            name: 'Accessories',
            description: 'Cases, chargers, and mobile accessories',
            products_count: 18,
            icon: 'accessories'
          },
          {
            id: 3,
            name: 'Gaming Phones',
            description: 'High-performance gaming smartphones',
            products_count: 12,
            icon: 'gaming'
          },
          {
            id: 4,
            name: 'Repair Services',
            description: 'Professional phone repair and maintenance',
            products_count: 5,
            icon: 'repair'
          },
          {
            id: 5,
            name: 'Premium Cases',
            description: 'Luxury phone cases and protection',
            products_count: 15,
            icon: 'cases'
          }
        ]);
      }
    } catch (err) {
      console.error('Error fetching categories:', err);
      setError('Failed to load categories');
      // Set fallback categories
      setCategories([
        {
          id: 1,
          name: 'Smartphones',
          description: 'Latest mobile phones from top brands',
          products_count: 25,
          icon: 'smartphone'
        },
        {
          id: 2,
          name: 'Accessories',
          description: 'Cases, chargers, and mobile accessories',
          products_count: 18,
          icon: 'accessories'
        }
      ]);
    } finally {
      setLoading(false);
    }
  };

  const getCategoryIcon = (categoryName, iconType) => {
    if (iconType === 'smartphone') return Smartphone;
    if (iconType === 'accessories') return Headphones;
    if (iconType === 'gaming') return Gamepad2;
    if (iconType === 'repair') return Shield;
    if (iconType === 'cases') return Shield;
    
    const iconMap = {
      'Smartphones': Smartphone,
      'Mobile Phones': Smartphone,
      'iPhone': Smartphone,
      'Samsung': Smartphone,
      'Accessories': Headphones,
      'Cases': Shield,
      'Chargers': Battery,
      'Cables': Battery,
      'Headphones': Headphones,
      'Repair Services': Shield,
      'Screen Protectors': Shield,
      'Power Banks': Battery,
      'Cameras': Camera,
      'Laptops': Laptop,
      'Gaming Phones': Gamepad2,
      'Premium Cases': Shield,
    };

    // Find matching icon by checking if category name contains any of the keywords
    for (const [keyword, Icon] of Object.entries(iconMap)) {
      if (categoryName.toLowerCase().includes(keyword.toLowerCase())) {
        return Icon;
      }
    }

    return Smartphone; // Default icon
  };

  const getCategoryGradient = (index) => {
    const gradients = [
      'from-blue-500 to-blue-600',
      'from-purple-500 to-purple-600',
      'from-red-500 to-red-600',
      'from-green-500 to-green-600',
      'from-yellow-500 to-yellow-600',
      'from-pink-500 to-pink-600',
      'from-indigo-500 to-indigo-600',
      'from-orange-500 to-orange-600',
    ];
    return gradients[index % gradients.length];
  };

  const getCategoryColor = (index) => {
    const colors = [
      'border-blue-500/30 bg-blue-500/10',
      'border-purple-500/30 bg-purple-500/10',
      'border-red-500/30 bg-red-500/10',
      'border-green-500/30 bg-green-500/10',
      'border-yellow-500/30 bg-yellow-500/10',
      'border-pink-500/30 bg-pink-500/10',
      'border-indigo-500/30 bg-indigo-500/10',
      'border-orange-500/30 bg-orange-500/10',
    ];
    return colors[index % colors.length];
  };

  if (loading) {
    return (
      <section className="py-20 bg-gaming-bg">
        <div className="container-custom">
          <div className="text-center mb-12">
            <div className="h-8 bg-gaming-card rounded animate-pulse mb-4 max-w-md mx-auto"></div>
            <div className="h-4 bg-gaming-card rounded animate-pulse max-w-lg mx-auto"></div>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            {[...Array(8)].map((_, index) => (
              <div key={index} className="card animate-pulse">
                <div className="h-32 bg-gaming-card mb-4"></div>
                <div className="p-6 space-y-3">
                  <div className="h-4 bg-gaming-card rounded w-3/4"></div>
                  <div className="h-4 bg-gaming-card rounded w-1/2"></div>
                  <div className="h-6 bg-gaming-card rounded w-1/3"></div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    );
  }

  if (error && categories.length === 0) {
    return (
      <section className="py-20 bg-gaming-bg">
        <div className="container-custom">
          <div className="text-center">
            <div className="w-24 h-24 mx-auto mb-6 bg-gaming-card rounded-full flex items-center justify-center">
              <Smartphone className="w-12 h-12 text-gold-400" />
            </div>
            <h3 className="text-xl font-semibold text-white mb-3">Failed to Load Categories</h3>
            <p className="text-gold-400 mb-6">{error}</p>
            <button 
              onClick={fetchCategories}
              className="btn btn-primary"
            >
              Try Again
            </button>
          </div>
        </div>
      </section>
    );
  }

  return (
    <section className="py-20 bg-gaming-bg relative overflow-hidden">
      {/* Background Pattern */}
      <div className="absolute inset-0 opacity-5">
        <div className="absolute inset-0" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
        }}></div>
      </div>

      <div className="container-custom relative">
        {/* Section Header */}
        <div className="text-center mb-16">
          <div className="inline-flex items-center space-x-2 bg-gold-500/20 border border-gold-500/30 text-gold-400 px-6 py-3 rounded-full text-sm font-semibold mb-6">
            <Crown className="w-5 h-5" />
            <span>Browse Categories</span>
          </div>
          
          <h2 className="text-4xl md:text-5xl font-bold text-white mb-6 font-gaming">
            Shop by Category
          </h2>
          <p className="text-xl text-gold-300 max-w-3xl mx-auto leading-relaxed">
            Discover our wide range of mobile phones, accessories, and services organized by category
          </p>
        </div>

        {/* Gaming Style Category Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-16">
          {categories.slice(0, 5).map((category, index) => {
            const Icon = getCategoryIcon(category.name, category.icon);
            const gradientColor = getCategoryGradient(index);
            const borderColor = getCategoryColor(index);
            
            return (
              <Link
                key={category.id}
                to={`/products?category=${category.id}`}
                className={`group card-gaming ${borderColor} hover:scale-105 transition-all duration-300`}
              >
                {/* Category Icon */}
                <div className={`h-32 bg-gradient-to-br ${gradientColor} flex items-center justify-center relative overflow-hidden`}>
                  <Icon className="w-16 h-16 text-white group-hover:scale-110 transition-transform duration-300 drop-shadow-lg" />
                  
                  {/* Hover Effect */}
                  <div className="absolute inset-0 bg-white/10 group-hover:bg-white/20 transition-all duration-300"></div>
                  
                  {/* Product Count Badge */}
                  <div className="absolute top-3 right-3 bg-black/50 backdrop-blur-sm rounded-full px-2 py-1 border border-white/30">
                    <span className="text-white text-xs font-bold">
                      {category.products_count || 0}
                    </span>
                  </div>

                  {/* Floating Elements */}
                  <div className="absolute top-3 left-3 w-2 h-2 bg-white/30 rounded-full animate-pulse"></div>
                  <div className="absolute bottom-4 right-4 w-1 h-1 bg-white/40 rounded-full animate-pulse delay-1000"></div>
                </div>

                {/* Category Info */}
                <div className="p-4 text-center">
                  <h3 className="text-lg font-semibold text-white mb-2 group-hover:text-gold-400 transition-colors duration-200">
                    {category.name}
                  </h3>
                  
                  {/* Category Button */}
                  <div className="mt-3">
                    <div className="inline-flex items-center justify-center w-full py-2 px-4 bg-gaming-card border border-gold-500/30 rounded-lg text-gold-400 text-sm font-medium group-hover:bg-gold-500/20 group-hover:border-gold-500/50 transition-all duration-200">
                      {category.name.split(' ')[0]}
                    </div>
                  </div>
                </div>
              </Link>
            );
          })}
        </div>

        {/* Featured Categories Section */}
        <div className="bg-gaming-card/50 backdrop-blur-sm rounded-3xl p-8 border border-gold-500/20 shadow-gaming">
          <div className="text-center mb-8">
            <div className="inline-flex items-center space-x-2 bg-gaming-bg border border-gold-500/30 text-gold-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
              <Star className="w-4 h-4" />
              <span>Featured Categories</span>
            </div>
            <h3 className="text-2xl font-bold text-white mb-3 font-gaming">
              Most Popular Categories
            </h3>
            <p className="text-gold-300">
              Most popular categories with the latest products and best deals
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {/* iPhone */}
            <Link
              to="/products?category=iphone"
              className="group bg-gaming-card rounded-2xl p-6 shadow-dark hover:shadow-gaming transition-all duration-300 border border-gaming-border hover:border-gold-500/50"
            >
              <div className="flex items-center space-x-4">
                <div className="w-16 h-16 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                  <Smartphone className="w-8 h-8 text-white" />
                </div>
                <div className="flex-1">
                  <h4 className="text-lg font-semibold text-white group-hover:text-gold-400 transition-colors duration-200">
                    iPhone Collection
                  </h4>
                  <p className="text-gold-300 text-sm">
                    Latest iPhone models and accessories
                  </p>
                </div>
                <ArrowRight className="w-5 h-5 text-gold-400 group-hover:text-gold-300 group-hover:translate-x-1 transition-all duration-200" />
              </div>
            </Link>

            {/* Samsung */}
            <Link
              to="/products?category=samsung"
              className="group bg-gaming-card rounded-2xl p-6 shadow-dark hover:shadow-gaming transition-all duration-300 border border-gaming-border hover:border-gold-500/50"
            >
              <div className="flex items-center space-x-4">
                <div className="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                  <Smartphone className="w-8 h-8 text-white" />
                </div>
                <div className="flex-1">
                  <h4 className="text-lg font-semibold text-white group-hover:text-gold-400 transition-colors duration-200">
                    Samsung Galaxy
                  </h4>
                  <p className="text-gold-300 text-sm">
                    Galaxy series smartphones and accessories
                  </p>
                </div>
                <ArrowRight className="w-5 h-5 text-gold-400 group-hover:text-gold-300 group-hover:translate-x-1 transition-all duration-200" />
              </div>
            </Link>

            {/* Gaming Phones */}
            <Link
              to="/products?category=gaming"
              className="group bg-gaming-card rounded-2xl p-6 shadow-dark hover:shadow-gaming transition-all duration-300 border border-gaming-border hover:border-gold-500/50"
            >
              <div className="flex items-center space-x-4">
                <div className="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                  <Gamepad2 className="w-8 h-8 text-white" />
                </div>
                <div className="flex-1">
                  <h4 className="text-lg font-semibold text-white group-hover:text-gold-400 transition-colors duration-200">
                    Gaming Phones
                  </h4>
                  <p className="text-gold-300 text-sm">
                    High-performance gaming smartphones
                  </p>
                </div>
                <ArrowRight className="w-5 h-5 text-gold-400 group-hover:text-gold-300 group-hover:translate-x-1 transition-all duration-200" />
              </div>
            </Link>
          </div>
        </div>
      </div>
    </section>
  );
};

export default CategorySection;