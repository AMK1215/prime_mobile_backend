import React, { useState, useEffect } from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import { ChevronLeft, ChevronRight, Play, Pause, Zap, Crown } from 'lucide-react';
import { apiService } from '../services/api';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

const BannerSlider = () => {
  const [banners, setBanners] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [isAutoplay, setIsAutoplay] = useState(true);

  useEffect(() => {
    fetchBanners();
  }, []);

  // Helper function to get the correct banner image URL
  const getBannerImageUrl = (banner) => {
    console.log('Banner object:', banner); // Debug log
    
    // If img_url already contains the full URL, use it
    if (banner.img_url && banner.img_url.startsWith('http')) {
      return banner.img_url;
    }
    
    // If img_url is a relative path, construct full URL
    if (banner.img_url) {
      // Handle different path formats
      let cleanPath = banner.img_url;
      
      // If it starts with /, remove it to avoid double slashes
      if (cleanPath.startsWith('/')) {
        cleanPath = cleanPath.substring(1);
      }
      
      // If it already contains 'assets/img/banners/', use it as is (public path, not API)
      if (cleanPath.includes('assets/img/banners/')) {
        const fullUrl = `https://sales.primemobilemm.site/${cleanPath}`;
        console.log('Constructed URL from img_url:', fullUrl);
        return fullUrl;
      }
      
      // Otherwise, construct the full path (public path, not API)
      const fullUrl = `https://sales.primemobilemm.site/assets/img/banners/${cleanPath}`;
      console.log('Constructed URL from img_url:', fullUrl);
      return fullUrl;
    }
    
    // If only image filename is provided, construct URL (public path, not API)
    if (banner.image) {
      const fullUrl = `https://sales.primemobilemm.site/assets/img/banners/${banner.image}`;
      console.log('Constructed URL from image:', fullUrl);
      return fullUrl;
    }
    
    // Fallback to Unsplash image
    console.log('Using fallback Unsplash image');
    return 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80';
  };

  const fetchBanners = async () => {
    try {
      setLoading(true);
      const response = await apiService.getBanners();
      
      console.log('Banner API Response:', response.data); // Debug log
      
      if (response.data.status === 'Request was successful.') {
        const bannerData = response.data.data || [];
        console.log('Setting banners:', bannerData); // Debug log
        
        // Log each banner's image URL for debugging
        bannerData.forEach((banner, index) => {
          console.log(`Banner ${index + 1} image URL:`, getBannerImageUrl(banner));
        });
        
        setBanners(bannerData);
      } else {
        // Fallback banners if API fails
        setBanners([
          {
            id: 1,
            image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            title: 'Premium Mobile Collection',
            subtitle: 'Discover the latest smartphones with cutting-edge technology',
            buttonText: 'Shop Now',
            buttonLink: '/products?category=iphone'
          },
          {
            id: 2,
            image: 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80',
            title: 'Gaming Smartphones',
            subtitle: 'Experience ultimate performance with our gaming phone collection',
            buttonText: 'Explore',
            buttonLink: '/products?category=gaming'
          },
          {
            id: 3,
            image: 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1967&q=80',
            title: 'Premium Accessories',
            subtitle: 'Complete your mobile experience with our premium accessories',
            buttonText: 'View All',
            buttonLink: '/products?category=accessories'
          }
        ]);
      }
    } catch (err) {
      console.error('Error fetching banners:', err);
      setError('Failed to load banners');
      // Set fallback banners
      setBanners([
        {
          id: 1,
          image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
          title: 'Premium Mobile Collection',
          subtitle: 'Discover the latest smartphones with cutting-edge technology',
          buttonText: 'Shop Now',
          buttonLink: '/products?category=iphone'
        }
      ]);
    } finally {
      setLoading(false);
    }
  };

  const toggleAutoplay = () => {
    setIsAutoplay(!isAutoplay);
  };

  if (loading) {
    return (
      <div className="relative h-96 md:h-[500px] lg:h-[600px] bg-gaming-bg animate-pulse">
        <div className="absolute inset-0 flex items-center justify-center">
          <div className="spinner w-12 h-12"></div>
        </div>
      </div>
    );
  }

  if (error && banners.length === 0) {
    return (
      <div className="relative h-96 md:h-[500px] lg:h-[600px] bg-gaming-bg flex items-center justify-center">
        <div className="text-center">
          <p className="text-gold-400 mb-4">{error}</p>
          <button 
            onClick={fetchBanners}
            className="btn btn-primary"
          >
            Try Again
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="relative overflow-hidden bg-gaming-bg">
      <Swiper
        modules={[Navigation, Pagination, Autoplay, EffectFade]}
        spaceBetween={0}
        slidesPerView={1}
        navigation={{
          nextEl: '.swiper-button-next-custom',
          prevEl: '.swiper-button-prev-custom',
        }}
        pagination={{
          clickable: true,
          bulletClass: 'swiper-pagination-bullet-custom',
          bulletActiveClass: 'swiper-pagination-bullet-active-custom',
        }}
        autoplay={isAutoplay ? {
          delay: 5000,
          disableOnInteraction: false,
        } : false}
        effect="fade"
        fadeEffect={{
          crossFade: true,
        }}
        loop={true}
        className="banner-swiper"
      >
        {banners.map((banner) => (
          <SwiperSlide key={banner.id}>
            <div className="relative h-96 md:h-[500px] lg:h-[600px] overflow-hidden">
              {/* Background Image */}
              <div className="absolute inset-0">
                <img 
                  src={getBannerImageUrl(banner)}
                  alt={`Banner ${banner.id}`}
                  className="absolute inset-0 w-full h-full object-cover"
                  onError={(e) => {
                    console.error('Banner image failed to load:', getBannerImageUrl(banner));
                    // Set fallback background
                    e.target.style.display = 'none';
                    e.target.parentElement.style.backgroundImage = 'url(https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80)';
                    e.target.parentElement.style.backgroundSize = 'cover';
                    e.target.parentElement.style.backgroundPosition = 'center';
                    e.target.parentElement.style.backgroundRepeat = 'no-repeat';
                  }}
                  onLoad={() => {
                    console.log('Banner image loaded successfully:', getBannerImageUrl(banner));
                  }}
                />
                {/* Gaming Gradient Overlay */}
                <div className="absolute inset-0 bg-gradient-to-r from-gaming-bg/80 via-gaming-bg/60 to-gaming-bg/80"></div>
              </div>

              {/* Content */}
              <div className="relative z-10 h-full flex items-center">
                <div className="container-custom">
                  <div className="max-w-3xl">
                    {/* Gaming Badge */}
                    {/* <div className="inline-flex items-center space-x-2 bg-gold-500/20 backdrop-blur-sm border border-gold-500/30 text-gold-400 px-4 py-2 rounded-full text-sm font-semibold mb-6 animate-fade-in">
                      <Crown className="w-4 h-4" />
                      <span>Premium Collection</span>
                    </div> */}

                    {/* <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight animate-slide-up font-gaming neon-text">
                      {banner.title || 'PhoneShop - Premium Mobile Store'}
                    </h1> */}
                    
                    {/* <p className="text-lg md:text-xl text-gold-200 mb-8 leading-relaxed max-w-2xl animate-slide-up">
                      {banner.subtitle || 'Your trusted mobile phone store - Discover the latest smartphones and accessories at unbeatable prices'}
                    </p> */}


                    {/* <div className="flex flex-col sm:flex-row gap-4 animate-slide-up">
                      <a
                        href={banner.buttonLink || '/products'}
                        className="btn btn-primary btn-lg px-8 py-4 text-lg font-semibold shadow-gaming hover:shadow-gaming-lg transform hover:-translate-y-0.5 transition-all duration-300"
                      >
                        <Zap className="w-5 h-5 mr-2" />
                        {banner.buttonText || 'Shop Now'}
                      </a>
                      <a
                        href="/categories"
                        className="btn btn-outline btn-lg px-8 py-4 text-lg font-semibold backdrop-blur-sm border-gold-500 text-gold-500 hover:bg-gold-500 hover:text-dark-900"
                      >
                        Browse Categories
                      </a>
                    </div> */}
                  </div>
                </div>
              </div>
            </div>
          </SwiperSlide>
        ))}
      </Swiper>

      {/* Custom Navigation Buttons */}
      <div className="swiper-button-prev-custom absolute left-4 top-1/2 transform -translate-y-1/2 z-20 w-12 h-12 bg-gaming-card/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-gaming hover:bg-gaming-card hover:shadow-gaming-lg transition-all duration-300 cursor-pointer gaming-border-glow">
        <ChevronLeft className="w-6 h-6 text-gold-400" />
      </div>
      <div className="swiper-button-next-custom absolute right-4 top-1/2 transform -translate-y-1/2 z-20 w-12 h-12 bg-gaming-card/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-gaming hover:bg-gaming-card hover:shadow-gaming-lg transition-all duration-300 cursor-pointer gaming-border-glow">
        <ChevronRight className="w-6 h-6 text-gold-400" />
      </div>

      {/* Autoplay Toggle */}
      <div className="absolute bottom-6 left-6 z-20">
        <button
          onClick={toggleAutoplay}
          className="w-12 h-12 bg-gaming-card/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-gaming hover:bg-gaming-card hover:shadow-gaming-lg transition-all duration-300 gaming-border-glow"
          aria-label={isAutoplay ? 'Pause slideshow' : 'Play slideshow'}
        >
          {isAutoplay ? (
            <Pause className="w-5 h-5 text-gold-400" />
          ) : (
            <Play className="w-5 h-5 text-gold-400" />
          )}
        </button>
      </div>

      {/* Custom Styles */}
      <style>{`
        .banner-swiper .swiper-pagination-bullet-custom {
          background: rgba(251, 191, 36, 0.5);
          opacity: 1;
          width: 12px;
          height: 12px;
          margin: 0 6px;
          transition: all 0.3s ease;
        }
        
        .banner-swiper .swiper-pagination-bullet-active-custom {
          background: #fbbf24;
          transform: scale(1.2);
          box-shadow: 0 0 10px #fbbf24;
        }
        
        .banner-swiper .swiper-pagination {
          bottom: 20px;
        }
      `}</style>
    </div>
  );
};

export default BannerSlider;