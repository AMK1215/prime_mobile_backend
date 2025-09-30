import React, { useState, useEffect } from 'react';
import { X, Gift, Clock, Star, Shield, Zap, ArrowRight } from 'lucide-react';
import { apiService } from '../services/api';

const BannerAds = () => {
  const [isVisible, setIsVisible] = useState(false);
  const [bannerAds, setBannerAds] = useState([]);
  const [currentAdIndex, setCurrentAdIndex] = useState(0);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Check if popup has been shown before
    const hasSeenPopup = localStorage.getItem('primeMobile_popupShown');
    if (!hasSeenPopup) {
      fetchBannerAds();
    }
  }, []);

  // Auto-rotate ads every 4 seconds
  useEffect(() => {
    if (bannerAds.length > 1 && isVisible) {
      const interval = setInterval(() => {
        setCurrentAdIndex((prevIndex) => 
          (prevIndex + 1) % bannerAds.length
        );
      }, 4000);
      return () => clearInterval(interval);
    }
  }, [bannerAds.length, isVisible]);

  const fetchBannerAds = async () => {
    try {
      setLoading(true);
      const response = await apiService.getBannerAds();
      
      if (response.data.status === 'Request was successful.' && response.data.data) {
        setBannerAds(response.data.data);
      } else {
        // Fallback banner ads
        setBannerAds([
          {
            id: 1,
            image: 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            title: 'Special Offer!',
            subtitle: 'Get 20% off on all iPhone accessories',
            discount: '20% OFF',
            validUntil: '2025-02-15'
          },
          {
            id: 2,
            image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            title: 'New Arrivals',
            subtitle: 'Latest smartphones now available',
            discount: 'FREE SHIPPING',
            validUntil: '2025-02-20'
          }
        ]);
      }
    } catch (err) {
      console.error('Error fetching banner ads:', err);
      // Set fallback ads
      setBannerAds([
        {
          id: 1,
          image: 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
          title: 'Welcome to Prime Mobile!',
          subtitle: 'Premium mobile store in Myanmar',
          discount: 'SPECIAL OFFER',
          validUntil: '2025-02-15'
        }
      ]);
    } finally {
      setLoading(false);
      if (bannerAds.length > 0) {
        setIsVisible(true);
      }
    }
  };

  const handleClose = () => {
    setIsVisible(false);
    localStorage.setItem('primeMobile_popupShown', 'true');
  };

  const handleShopNow = () => {
    window.location.href = '/products';
    handleClose();
  };

  if (!isVisible || loading || bannerAds.length === 0) {
    return null;
  }

  const currentAd = bannerAds[currentAdIndex];

  return (
    <div className="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fade-in">
      <div className="relative w-full max-w-2xl bg-white rounded-3xl shadow-hard overflow-hidden animate-scale-in">
        {/* Close Button */}
        <button
          onClick={handleClose}
          className="absolute top-4 right-4 z-10 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-secondary-600 hover:text-secondary-800 hover:bg-white shadow-lg transition-all duration-200 hover:scale-110"
          aria-label="Close popup"
        >
          <X className="w-5 h-5" />
        </button>

        {/* Ad Content */}
        <div className="relative">
          {/* Background Image */}
          <div 
            className="h-80 bg-cover bg-center relative"
            style={{
              backgroundImage: `url(${currentAd.image || currentAd.img_url || 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'})`
            }}
          >
            {/* Gradient Overlay */}
            <div className="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-black/60"></div>
            
            {/* Content */}
            <div className="absolute inset-0 flex items-center p-8">
              <div className="max-w-lg">
                {/* Discount Badge */}
                <div className="inline-flex items-center space-x-2 bg-gradient-to-r from-danger-500 to-danger-600 text-white px-4 py-2 rounded-full text-sm font-bold mb-4 shadow-lg">
                  <Gift className="w-4 h-4" />
                  <span>{currentAd.discount || 'SPECIAL OFFER'}</span>
                </div>

                <h2 className="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">
                  {currentAd.title || 'Special Offer'}
                </h2>
                
                <p className="text-lg text-gray-200 mb-6 leading-relaxed">
                  {currentAd.subtitle || 'Don\'t miss out on this amazing deal!'}
                </p>

                {/* Features */}
                <div className="flex flex-wrap gap-4 mb-6">
                  <div className="flex items-center space-x-2 text-white/90">
                    <Shield className="w-4 h-4 text-primary-400" />
                    <span className="text-sm font-medium">Genuine Products</span>
                  </div>
                  <div className="flex items-center space-x-2 text-white/90">
                    <Star className="w-4 h-4 text-primary-400" />
                    <span className="text-sm font-medium">Premium Quality</span>
                  </div>
                  <div className="flex items-center space-x-2 text-white/90">
                    <Clock className="w-4 h-4 text-primary-400" />
                    <span className="text-sm font-medium">Limited Time</span>
                  </div>
                </div>

                {/* Valid Until */}
                {currentAd.validUntil && (
                  <div className="flex items-center space-x-2 text-yellow-300 mb-6">
                    <Clock className="w-4 h-4" />
                    <span className="text-sm font-medium">
                      Valid until: {new Date(currentAd.validUntil).toLocaleDateString()}
                    </span>
                  </div>
                )}

                {/* Action Buttons */}
                <div className="flex flex-col sm:flex-row gap-4">
                  <button
                    onClick={handleShopNow}
                    className="btn bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800 px-8 py-3 text-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center space-x-2"
                  >
                    <Zap className="w-5 h-5" />
                    <span>Shop Now</span>
                  </button>
                  
                  <button
                    onClick={handleClose}
                    className="btn bg-white/20 backdrop-blur-sm text-white border border-white/30 hover:bg-white/30 px-8 py-3 text-lg font-semibold transition-all duration-300 flex items-center justify-center space-x-2"
                  >
                    <span>Maybe Later</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          {/* Ad Indicators */}
          {bannerAds.length > 1 && (
            <div className="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
              {bannerAds.map((_, index) => (
                <button
                  key={index}
                  onClick={() => setCurrentAdIndex(index)}
                  className={`w-3 h-3 rounded-full transition-all duration-300 ${
                    index === currentAdIndex 
                      ? 'bg-white scale-125 shadow-lg' 
                      : 'bg-white/50 hover:bg-white/75'
                  }`}
                  aria-label={`Go to ad ${index + 1}`}
                />
              ))}
            </div>
          )}

          {/* Countdown Timer (if validUntil is provided) */}
          {currentAd.validUntil && (
            <div className="absolute top-4 left-4 bg-black/50 backdrop-blur-sm rounded-lg px-3 py-2 border border-white/20">
              <div className="flex items-center space-x-2 text-white">
                <Clock className="w-4 h-4 text-yellow-400" />
                <span className="text-sm font-medium">
                  {Math.ceil((new Date(currentAd.validUntil) - new Date()) / (1000 * 60 * 60 * 24))} days left
                </span>
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default BannerAds;