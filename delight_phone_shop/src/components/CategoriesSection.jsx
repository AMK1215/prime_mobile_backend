import React, { useState, useEffect } from 'react';
import { Smartphone, Headphones, Battery, Shield, Camera, Wifi, Quote } from 'lucide-react';
import { apiService } from '../services/api';

const CategoriesSection = () => {
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchCategories();
  }, []);

  const fetchCategories = async () => {
    try {
      // Try to get all categories first
      const response = await apiService.getAllCategories();
      
      if (response.data.status === 'Request was successful.' && response.data.data) {
        // Filter out top-level categories and get their children for phone shop
        const allCategories = response.data.data;
        const phoneShopCategories = [];
        
        // Find Electronics category and get its children
        const electronics = allCategories.find(cat => cat.name === 'Electronics');
        if (electronics && electronics.children) {
          // Add the main phone categories
          phoneShopCategories.push(...electronics.children);
          
          // Also add sub-categories if they exist
          electronics.children.forEach(child => {
            if (child.children && child.children.length > 0) {
              phoneShopCategories.push(...child.children);
            }
          });
        }
        
        // If we have phone shop categories, use them, otherwise use all categories
        const displayCategories = phoneShopCategories.length > 0 ? phoneShopCategories : allCategories.slice(0, 6);
        setCategories(displayCategories);
      } else {
        // Fallback categories
        setCategories([
          { id: 1, name: 'Mobile Phones', products_count: 25 },
          { id: 2, name: 'Android Phones', products_count: 15 },
          { id: 3, name: 'iOS Phones', products_count: 10 },
          { id: 4, name: 'Phone Accessories', products_count: 30 },
          { id: 5, name: 'Phone Cases', products_count: 20 },
          { id: 6, name: 'Chargers & Cables', products_count: 18 }
        ]);
      }
    } catch (err) {
      console.error('Error fetching categories:', err);
      // Set fallback categories
      setCategories([
        { id: 1, name: 'Mobile Phones', products_count: 25 },
        { id: 2, name: 'Android Phones', products_count: 15 },
        { id: 3, name: 'iOS Phones', products_count: 10 },
        { id: 4, name: 'Phone Accessories', products_count: 30 }
      ]);
    } finally {
      setLoading(false);
    }
  };

  // Get category icon based on category name
  const getCategoryIcon = (categoryName) => {
    const name = categoryName.toLowerCase();
    if (name.includes('mobile phones')) return Smartphone;
    if (name.includes('android phones')) return Smartphone;
    if (name.includes('ios phones')) return Smartphone;
    if (name.includes('phone accessories')) return Headphones;
    if (name.includes('phone cases')) return Shield;
    if (name.includes('chargers & cables')) return Battery;
    if (name.includes('screen protectors')) return Wifi;
    if (name.includes('electronics')) return Camera;
    return Smartphone; // Default icon
  };

  // Get category color based on category name
  const getCategoryColor = (categoryName) => {
    const name = categoryName.toLowerCase();
    if (name.includes('mobile phones')) return 'from-blue-500 to-blue-600';
    if (name.includes('android phones')) return 'from-green-500 to-green-600';
    if (name.includes('ios phones')) return 'from-gray-500 to-gray-600';
    if (name.includes('phone accessories')) return 'from-purple-500 to-purple-600';
    if (name.includes('phone cases')) return 'from-pink-500 to-pink-600';
    if (name.includes('chargers & cables')) return 'from-orange-500 to-orange-600';
    if (name.includes('screen protectors')) return 'from-cyan-500 to-cyan-600';
    if (name.includes('electronics')) return 'from-red-500 to-red-600';
    return 'from-blue-500 to-blue-600'; // Default color
  };

  if (loading) {
    return (
      <section className="py-8 bg-gray-900">
        <div className="container-custom">
          <div className="mb-8">
            <div className="flex items-center justify-between mb-6">
              <div className="h-8 bg-gray-700 rounded w-32 animate-pulse"></div>
              <div className="h-4 bg-gray-700 rounded w-24 animate-pulse"></div>
            </div>
            
            <div className="flex space-x-4 overflow-x-auto pb-4">
              {[...Array(6)].map((_, index) => (
                <div key={index} className="flex-shrink-0 w-48 bg-gray-800 border border-gray-700 rounded-xl p-4 animate-pulse">
                  <div className="w-16 h-16 bg-gray-700 rounded-full mx-auto mb-3"></div>
                  <div className="h-6 bg-gray-700 rounded mx-auto w-16"></div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>
    );
  }

  return (
    <section className="py-8 bg-gray-900">
      <div className="container-custom">
        {/* Categories Section - Phone Shop Style */}
        <div className="mb-8">
          <div className="flex items-center justify-between mb-6">
            <h3 className="text-2xl font-bold text-yellow-400 font-gaming">Categories</h3>
            <div className="flex items-center space-x-2 text-gray-300">
              <Quote className="w-5 h-5" />
              <span className="text-sm">မြင်နိုင်သည်</span>
            </div>
          </div>

          {/* Horizontal Scrollable Category Cards */}
          <div className="flex space-x-4 overflow-x-auto pb-4">
            {categories.map((category) => {
              const IconComponent = getCategoryIcon(category.name);
              const colorClass = getCategoryColor(category.name);
              
              return (
                <div 
                  key={category.id} 
                  className="flex-shrink-0 w-48 bg-gray-900 border border-yellow-500/20 rounded-xl p-4 hover:border-yellow-500 transition-all duration-300 cursor-pointer"
                  onClick={() => window.location.href = `/products/category/${category.id}`}
                >
                  <div className="text-center">
                    {/* Circular Icon with Golden Border */}
                    <div className="relative w-20 h-20 mx-auto mb-4">
                      <div className={`w-20 h-20 bg-gradient-to-br ${colorClass} rounded-full flex items-center justify-center border-2 border-yellow-500 shadow-lg`}>
                        <IconComponent className="w-10 h-10 text-white" />
                      </div>
                    </div>
                    
                    {/* Pill-shaped Label */}
                    <div className="bg-yellow-500 rounded-full px-4 py-2 inline-block">
                      <h4 className="text-gray-900 font-semibold text-sm truncate max-w-32">
                        {category.name.length > 12 ? category.name.substring(0, 12) + '...' : category.name}
                      </h4>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </div>
    </section>
  );
};

export default CategoriesSection;
