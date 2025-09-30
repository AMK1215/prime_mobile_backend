import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { 
  Menu, 
  X, 
  Globe, 
  Phone, 
  ShoppingBag, 
  Search,
  User,
  Heart,
  Crown,
  Star
} from 'lucide-react';
import logo from '../assets/logo.jpg';

const Navbar = ({ onToggleSidebar, isSidebarOpen }) => {
  const navigate = useNavigate();
  const [isLanguageOpen, setIsLanguageOpen] = useState(false);
  const [currentLanguage, setCurrentLanguage] = useState('mm');
  const [isSearchOpen, setIsSearchOpen] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');

  const languages = [
    { code: 'mm', name: 'မြန်မာ', flag: '🇲🇲' },
    { code: 'en', name: 'English', flag: '🇺🇸' }
  ];

  const handleLanguageChange = (langCode) => {
    setCurrentLanguage(langCode);
    setIsLanguageOpen(false);
  };

  const handleSearch = (e) => {
    e.preventDefault();
    if (searchQuery.trim()) {
      navigate(`/products?search=${encodeURIComponent(searchQuery.trim())}`);
      setIsSearchOpen(false);
      setSearchQuery('');
    }
  };

  const currentLang = languages.find(lang => lang.code === currentLanguage);

  return (
    <nav className="bg-gray-900/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-yellow-500/30">
      <div className="container-custom">
        <div className="flex items-center justify-between h-14 sm:h-16">
          {/* Logo */}
          <Link to="/" className="flex items-center space-x-3 group">
            <img 
              src={logo} 
              alt="Prime Mobile Logo" 
              className="w-8 h-8 sm:w-10 sm:h-10 rounded-xl object-cover shadow-lg group-hover:shadow-xl transition-all duration-300"
            />
            <div className="hidden sm:block">
              <h1 className="text-lg sm:text-xl font-bold text-gradient-gold font-gaming">PRIME MOBILE</h1>
              <p className="text-xs text-yellow-400 font-medium">Premium Mobile Store</p>
            </div>
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden lg:flex items-center space-x-8">
            <Link 
              to="/" 
              className="text-gold-400 hover:text-gold-300 font-medium transition-all duration-200 relative group"
            >
              Home
              <span className="absolute -bottom-1 left-0 w-0 h-0.5 bg-gold-500 group-hover:w-full transition-all duration-200"></span>
            </Link>
            <Link 
              to="/products" 
              className="text-gold-400 hover:text-gold-300 font-medium transition-all duration-200 relative group"
            >
              Products
              <span className="absolute -bottom-1 left-0 w-0 h-0.5 bg-gold-500 group-hover:w-full transition-all duration-200"></span>
            </Link>
            <Link 
              to="/categories" 
              className="text-gold-400 hover:text-gold-300 font-medium transition-all duration-200 relative group"
            >
              Categories
              <span className="absolute -bottom-1 left-0 w-0 h-0.5 bg-gold-500 group-hover:w-full transition-all duration-200"></span>
            </Link>
            <Link 
              to="/about" 
              className="text-gold-400 hover:text-gold-300 font-medium transition-all duration-200 relative group"
            >
              About
              <span className="absolute -bottom-1 left-0 w-0 h-0.5 bg-gold-500 group-hover:w-full transition-all duration-200"></span>
            </Link>
            <Link 
              to="/contact" 
              className="text-gold-400 hover:text-gold-300 font-medium transition-all duration-200 relative group"
            >
              Contact
              <span className="absolute -bottom-1 left-0 w-0 h-0.5 bg-gold-500 group-hover:w-full transition-all duration-200"></span>
            </Link>
          </div>

          {/* Right Side Actions */}
          <div className="flex items-center space-x-1 sm:space-x-3">
            {/* Search Button */}
            <button
              onClick={() => setIsSearchOpen(!isSearchOpen)}
              className="p-2 sm:p-2.5 text-yellow-400 hover:text-yellow-300 hover:bg-gray-800 rounded-lg transition-all duration-200 border border-yellow-500/30"
              aria-label="Search"
            >
              <Search className="w-5 h-5" />
            </button>

            {/* Language Switcher */}
            <div className="relative">
              <button
                onClick={() => setIsLanguageOpen(!isLanguageOpen)}
                className="flex items-center space-x-2 p-2 sm:p-2.5 text-yellow-400 hover:text-yellow-300 hover:bg-gray-800 rounded-lg transition-all duration-200 border border-yellow-500/30"
                aria-label="Change Language"
              >
                <Globe className="w-5 h-5" />
                <span className="hidden sm:block text-sm font-medium">
                  {currentLang?.flag} {currentLang?.name}
                </span>
              </button>

              {/* Language Dropdown */}
              {isLanguageOpen && (
                <div className="absolute right-0 mt-2 w-48 bg-gray-800 rounded-xl shadow-xl border border-yellow-500/30 py-2 z-50 animate-fade-in">
                  {languages.map((lang) => (
                    <button
                      key={lang.code}
                      onClick={() => handleLanguageChange(lang.code)}
                      className={`w-full px-4 py-3 text-left hover:bg-gray-900 transition-colors flex items-center space-x-3 ${
                        currentLanguage === lang.code ? 'bg-gray-900 text-yellow-300' : 'text-yellow-400'
                      }`}
                    >
                      <span className="text-lg">{lang.flag}</span>
                      <span className="font-medium">{lang.name}</span>
                      {currentLanguage === lang.code && (
                        <span className="ml-auto text-yellow-500">✓</span>
                      )}
                    </button>
                  ))}
                </div>
              )}
            </div>


            {/* Wishlist */}
            <button className="relative p-2 sm:p-2.5 text-yellow-400 hover:text-yellow-300 hover:bg-gray-800 rounded-lg transition-all duration-200 border border-yellow-500/30">
              <Heart className="w-4 h-4 sm:w-5 sm:h-5" />
              <span className="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center font-medium">
                0
              </span>
            </button>

            {/* Shopping Cart */}
            <Link
              to="/cart"
              className="relative p-2 sm:p-2.5 text-yellow-400 hover:text-yellow-300 hover:bg-gray-800 rounded-lg transition-all duration-200 border border-yellow-500/30"
              aria-label="Shopping Cart"
            >
              <ShoppingBag className="w-4 h-4 sm:w-5 sm:h-5" />
              <span className="absolute -top-1 -right-1 bg-yellow-500 text-gray-900 text-xs rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center font-medium">
                0
              </span>
            </Link>

            {/* Mobile Menu Button */}
            <button
              onClick={onToggleSidebar}
              className="lg:hidden p-2 sm:p-2.5 text-yellow-400 hover:text-yellow-300 hover:bg-gray-800 rounded-lg transition-all duration-200 border border-yellow-500/30"
              aria-label="Toggle Menu"
            >
              {isSidebarOpen ? (
                <X className="w-5 h-5 sm:w-6 sm:h-6" />
              ) : (
                <Menu className="w-5 h-5 sm:w-6 sm:h-6" />
              )}
            </button>
          </div>
        </div>

        {/* Mobile Search Bar */}
        {isSearchOpen && (
          <div className="py-4 border-t border-yellow-500/30 animate-slide-down">
            <form onSubmit={handleSearch}>
              <div className="relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-400 w-5 h-5" />
                <input
                  type="text"
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  placeholder={currentLanguage === 'mm' ? 'ဖုန်းရှာဖွေရန်...' : 'Search phones...'}
                  className="w-full pl-10 pr-4 py-3 bg-gray-800 text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 placeholder-gray-400"
                />
              </div>
            </form>
          </div>
        )}
      </div>

      {/* Language Dropdown Overlay */}
      {isLanguageOpen && (
        <div
          className="fixed inset-0 z-40"
          onClick={() => setIsLanguageOpen(false)}
        />
      )}
    </nav>
  );
};

export default Navbar;