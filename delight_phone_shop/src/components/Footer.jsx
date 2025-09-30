import React from 'react';
import { Link } from 'react-router-dom';
import { 
  Phone, 
  Mail, 
  MapPin, 
  Clock, 
  Facebook, 
  Instagram, 
  Twitter, 
  Youtube,
  Shield,
  Truck,
  RefreshCw,
  Headphones,
  Heart,
  Award,
  Zap,
  Crown,
  Star
} from 'lucide-react';
import logo from '../assets/logo.jpg';

const Footer = () => {
  const currentYear = new Date().getFullYear();

  const quickLinks = [
    { name: 'Home', path: '/' },
    { name: 'Products', path: '/products' },
    { name: 'Categories', path: '/categories' },
    { name: 'About Us', path: '/about' },
    { name: 'Contact', path: '/contact' },
    { name: 'FAQ', path: '/faq' },
  ];

  const productCategories = [
    { name: 'iPhone', path: '/products?category=iphone' },
    { name: 'Samsung', path: '/products?category=samsung' },
    { name: 'Accessories', path: '/products?category=accessories' },
    { name: 'Cases', path: '/products?category=cases' },
    { name: 'Chargers', path: '/products?category=chargers' },
    { name: 'Repair Service', path: '/repair' },
  ];

  const services = [
    { name: 'Phone Repair', path: '/services/repair' },
    { name: 'Screen Replacement', path: '/services/screen' },
    { name: 'Battery Replacement', path: '/services/battery' },
    { name: 'Data Recovery', path: '/services/data' },
    { name: 'Warranty Service', path: '/services/warranty' },
    { name: 'Trade-in Program', path: '/services/trade-in' },
  ];

  const socialLinks = [
    { name: 'Facebook', icon: Facebook, url: 'https://facebook.com/primemobile', color: 'hover:text-blue-400' },
    { name: 'Instagram', icon: Instagram, url: 'https://instagram.com/primemobile', color: 'hover:text-pink-400' },
    { name: 'Twitter', icon: Twitter, url: 'https://twitter.com/primemobile', color: 'hover:text-blue-300' },
    { name: 'YouTube', icon: Youtube, url: 'https://youtube.com/primemobile', color: 'hover:text-red-400' },
  ];

  const contactInfo = {
    phone: '+95 9 123 456 789',
    email: 'info@primemobile.com',
    address: '123 Mobile Street, Mandalay, Myanmar',
    hours: 'Mon-Sat: 9:00 AM - 8:00 PM, Sun: 10:00 AM - 6:00 PM'
  };

  const features = [
    {
      icon: Shield,
      title: 'Genuine Products',
      description: '100% authentic products with warranty'
    },
    {
      icon: Truck,
      title: 'Free Delivery',
      description: 'Free delivery on orders above $100'
    },
    {
      icon: RefreshCw,
      title: 'Easy Returns',
      description: '30-day return policy'
    },
    {
      icon: Headphones,
      title: '24/7 Support',
      description: 'Round-the-clock customer support'
    }
  ];

  return (
    <footer className="bg-gaming-bg text-white relative overflow-hidden border-t border-gold-500/30">
      {/* Background Pattern */}
      <div className="absolute inset-0 opacity-5">
        <div className="absolute inset-0" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
        }}></div>
      </div>

      {/* Main Footer */}
      <div className="container-custom py-16 relative">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {/* Company Info */}
          <div className="lg:col-span-1">
            <div className="flex items-center space-x-3 mb-6">
              <img 
                src={logo} 
                alt="Prime Mobile Logo" 
                className="w-12 h-12 rounded-xl object-cover shadow-gaming"
              />
              <div>
                <h3 className="text-2xl font-bold text-white font-gaming">PRIME MOBILE</h3>
                <p className="text-sm text-gold-400 font-medium">Premium Mobile Store</p>
              </div>
            </div>
            
            <p className="text-gold-300 mb-6 leading-relaxed">
              Your trusted destination for premium smartphones, accessories, and repair services in Myanmar. 
              We offer genuine products with excellent customer service.
            </p>

            {/* Contact Info */}
            <div className="space-y-3">
              <div className="flex items-center space-x-3 text-gold-300">
                <div className="w-8 h-8 bg-gold-500/20 rounded-lg flex items-center justify-center">
                  <Phone className="w-4 h-4 text-gold-400" />
                </div>
                <span className="text-sm">{contactInfo.phone}</span>
              </div>
              <div className="flex items-center space-x-3 text-gold-300">
                <div className="w-8 h-8 bg-gold-500/20 rounded-lg flex items-center justify-center">
                  <Mail className="w-4 h-4 text-gold-400" />
                </div>
                <span className="text-sm">{contactInfo.email}</span>
              </div>
              <div className="flex items-start space-x-3 text-gold-300">
                <div className="w-8 h-8 bg-gold-500/20 rounded-lg flex items-center justify-center mt-0.5">
                  <MapPin className="w-4 h-4 text-gold-400" />
                </div>
                <span className="text-sm">{contactInfo.address}</span>
              </div>
              <div className="flex items-start space-x-3 text-gold-300">
                <div className="w-8 h-8 bg-gold-500/20 rounded-lg flex items-center justify-center mt-0.5">
                  <Clock className="w-4 h-4 text-gold-400" />
                </div>
                <span className="text-sm">{contactInfo.hours}</span>
              </div>
            </div>

            {/* Social Links */}
            <div className="flex space-x-3 mt-6">
              {socialLinks.map((social) => {
                const Icon = social.icon;
                return (
                  <a
                    key={social.name}
                    href={social.url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className={`w-10 h-10 bg-gaming-card/50 backdrop-blur-sm rounded-lg flex items-center justify-center text-gold-400 transition-all duration-300 hover:bg-gold-500/20 hover:text-gold-300 hover:scale-110 gaming-border ${social.color}`}
                    aria-label={social.name}
                  >
                    <Icon className="w-5 h-5" />
                  </a>
                );
              })}
            </div>
          </div>

          {/* Quick Links */}
          <div>
            <h4 className="text-lg font-semibold mb-6 text-white font-gaming">Quick Links</h4>
            <ul className="space-y-3">
              {quickLinks.map((link) => (
                <li key={link.name}>
                  <Link
                    to={link.path}
                    className="text-gold-300 hover:text-gold-400 transition-colors duration-200 text-sm flex items-center group"
                  >
                    <span className="w-0 group-hover:w-2 h-0.5 bg-gold-400 transition-all duration-200 mr-0 group-hover:mr-2"></span>
                    {link.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Product Categories */}
          <div>
            <h4 className="text-lg font-semibold mb-6 text-white font-gaming">Categories</h4>
            <ul className="space-y-3">
              {productCategories.map((category) => (
                <li key={category.name}>
                  <Link
                    to={category.path}
                    className="text-gold-300 hover:text-gold-400 transition-colors duration-200 text-sm flex items-center group"
                  >
                    <span className="w-0 group-hover:w-2 h-0.5 bg-gold-400 transition-all duration-200 mr-0 group-hover:mr-2"></span>
                    {category.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Services */}
          <div>
            <h4 className="text-lg font-semibold mb-6 text-white font-gaming">Services</h4>
            <ul className="space-y-3">
              {services.map((service) => (
                <li key={service.name}>
                  <Link
                    to={service.path}
                    className="text-gold-300 hover:text-gold-400 transition-colors duration-200 text-sm flex items-center group"
                  >
                    <span className="w-0 group-hover:w-2 h-0.5 bg-gold-400 transition-all duration-200 mr-0 group-hover:mr-2"></span>
                    {service.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        </div>

        {/* Features Section */}
        <div className="mt-16 pt-8 border-t border-gaming-border">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {features.map((feature, index) => {
              const Icon = feature.icon;
              return (
                <div key={index} className="text-center group">
                  <div className="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-600 rounded-2xl mb-4 shadow-gaming group-hover:shadow-gaming-lg transition-all duration-300 group-hover:scale-110">
                    <Icon className="w-8 h-8 text-dark-900" />
                  </div>
                  <h5 className="font-semibold mb-2 text-white">{feature.title}</h5>
                  <p className="text-gold-300 text-sm">{feature.description}</p>
                </div>
              );
            })}
          </div>
        </div>
      </div>

      {/* Bottom Footer */}
      <div className="bg-gaming-card/50 py-6 relative border-t border-gaming-border">
        <div className="container-custom">
          <div className="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            <div className="text-center md:text-left">
              <p className="text-gold-300 text-sm">
                © {currentYear} Prime Mobile Shop. All rights reserved.
              </p>
            </div>
            
            <div className="flex items-center space-x-6 text-sm">
              <Link to="/privacy" className="text-gold-300 hover:text-gold-400 transition-colors duration-200">
                Privacy Policy
              </Link>
              <Link to="/terms" className="text-gold-300 hover:text-gold-400 transition-colors duration-200">
                Terms of Service
              </Link>
              <Link to="/shipping" className="text-gold-300 hover:text-gold-400 transition-colors duration-200">
                Shipping Info
              </Link>
              <Link to="/returns" className="text-gold-300 hover:text-gold-400 transition-colors duration-200">
                Returns
              </Link>
            </div>
          </div>
          
          <div className="mt-4 pt-4 border-t border-gaming-border text-center">
            <p className="text-gold-400 text-xs flex items-center justify-center space-x-2">
              <span>Made with</span>
              <Heart className="w-3 h-3 text-red-500 fill-current" />
              <span>in Myanmar</span>
              <span>•</span>
              <span>Premium Mobile Store Since 2020</span>
            </p>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;