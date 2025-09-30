import React, { useState, useEffect } from 'react';
import { Quote } from 'lucide-react';
import { apiService } from '../services/api';

const BannerText = () => {
  const [bannerTexts, setBannerTexts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [currentTextIndex, setCurrentTextIndex] = useState(0);

  useEffect(() => {
    fetchBannerTexts();
  }, []);

  // Auto-rotate text every 5 seconds
  useEffect(() => {
    if (bannerTexts.length > 1) {
      const interval = setInterval(() => {
        setCurrentTextIndex((prevIndex) => 
          (prevIndex + 1) % bannerTexts.length
        );
      }, 5000);
      return () => clearInterval(interval);
    }
  }, [bannerTexts.length]);

  const fetchBannerTexts = async () => {
    try {
      setLoading(true);
      const response = await apiService.getBannerText();
      
      console.log('Banner Text API Response:', response.data); // Debug log
      
      if (response.data.status === 'Request was successful.' && response.data.data) {
        // Handle both array and single object responses
        const bannerData = Array.isArray(response.data.data) ? response.data.data : [response.data.data];
        
        // If all banner texts are the same, add some variety
        const uniqueTexts = [...new Set(bannerData.map(item => item.text))];
        if (uniqueTexts.length === 1 && bannerData.length > 1) {
          // Add variety to the banner texts
          const variedBannerTexts = [
            ...bannerData,
            {
              id: 999,
              text: 'Premium smartphones and accessories at unbeatable prices'
            },
            {
              id: 998,
              text: 'Expert repair services and genuine parts guarantee'
            }
          ];
          setBannerTexts(variedBannerTexts);
        } else {
          setBannerTexts(bannerData);
        }
      } else {
        // Fallback banner texts
        setBannerTexts([
          {
            id: 1,
            text: 'Welcome to PhoneShop - Your trusted mobile phone store in Myanmar'
          },
          {
            id: 2,
            text: 'Premium smartphones and accessories at unbeatable prices'
          },
          {
            id: 3,
            text: 'Expert repair services and genuine parts guarantee'
          }
        ]);
      }
    } catch (err) {
      console.error('Error fetching banner texts:', err);
      // Set fallback texts
      setBannerTexts([
        {
          id: 1,
          text: 'Welcome to PhoneShop - Your trusted mobile phone store'
        },
        {
          id: 2,
          text: 'Premium smartphones and accessories at unbeatable prices'
        }
      ]);
    } finally {
      setLoading(false);
    }
  };

  // Helper function to get current text
  const getCurrentText = () => {
    if (bannerTexts.length > 0 && bannerTexts[currentTextIndex]) {
      return bannerTexts[currentTextIndex].text || 'Welcome to PhoneShop - Your trusted mobile phone store';
    }
    return 'Welcome to PhoneShop - Your trusted mobile phone store';
  };

  if (loading) {
    return (
      <section className="py-8 bg-gray-900">
        <div className="container-custom">
          {/* Loading Banner Text Box */}
          <div className="bg-gradient-to-r from-gray-800 to-gray-900 border border-yellow-500 rounded-xl p-6 mb-8 shadow-lg animate-pulse">
            <div className="flex items-center space-x-4">
              <div className="w-10 h-10 bg-gray-700 rounded-full"></div>
              <div className="flex-1 min-w-0">
                <div className="relative overflow-hidden">
                  <div className="animate-marquee whitespace-nowrap">
                    <span className="h-6 bg-gray-700 rounded mr-8 inline-block w-96"></span>
                    <span className="h-6 bg-gray-700 rounded mr-8 inline-block w-96"></span>
                  </div>
                </div>
                <div className="h-4 bg-gray-700 rounded w-1/3 mt-1"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
    );
  }

  return (
    <section className="py-8 bg-gray-900">
      <div className="container-custom">
        {/* Dark Banner Text Box with Marquee */}
        <div className="bg-gradient-to-r from-gray-800 to-gray-900 border border-yellow-500 rounded-xl p-6 mb-8 shadow-lg overflow-hidden">
          <div className="flex items-center space-x-4">
            <div className="flex-shrink-0">
              <div className="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                <Quote className="w-6 h-6 text-gray-900" />
              </div>
            </div>
            <div className="flex-1 min-w-0">
              {/* Marquee Text */}
              <div className="relative overflow-hidden">
                <div className={`whitespace-nowrap ${getCurrentText().length > 50 ? 'animate-marquee-slow' : 'animate-marquee'}`}>
                  <span className="text-white text-xl font-semibold mr-8">
                    {getCurrentText()}
                  </span>
                  {/* Duplicate for seamless loop */}
                  <span className="text-white text-xl font-semibold mr-8">
                    {getCurrentText()}
                  </span>
                </div>
              </div>
              <p className="text-gray-300 text-sm mt-1">ကြိုး</p>
            </div>
          </div>
        </div>

      </div>
    </section>
  );
};

export default BannerText;