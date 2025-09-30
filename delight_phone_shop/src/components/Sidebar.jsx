import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import { 
  Home, 
  Smartphone, 
  Grid3X3, 
  Info, 
  Mail, 
  Phone,
  Star,
  TrendingUp,
  Award,
  X,
  Heart,
  Apple,
  ShoppingBag,
  Wrench,
  HelpCircle
} from 'lucide-react';
import logo from '../assets/logo.jpg';

const Sidebar = ({ isOpen, onClose }) => {
  const location = useLocation();

  const navigationItems = [
    {
      name: 'Home',
      nameMM: 'ပင်မ',
      path: '/',
      icon: Home
    },
    {
      name: 'All Products',
      nameMM: 'ထုတ်ကုန်အားလုံး',
      path: '/products',
      icon: Smartphone
    },
    {
      name: 'Categories',
      nameMM: 'အမျိုးအစားများ',
      path: '/categories',
      icon: Grid3X3
    },
    {
      name: 'Featured',
      nameMM: 'အထူးပြထားသော',
      path: '/featured',
      icon: Star
    },
    {
      name: 'Best Sellers',
      nameMM: 'အရောင်းရဆုံး',
      path: '/best-sellers',
      icon: TrendingUp
    },
    {
      name: 'New Arrivals',
      nameMM: 'အသစ်ရောက်ရှိသော',
      path: '/new-arrivals',
      icon: Award
    },
    {
      name: 'FAQ',
      nameMM: 'မေးလေ့ရှိသောမေးခွန်းများ',
      path: '/faq',
      icon: HelpCircle
    },
    {
      name: 'About Us',
      nameMM: 'ကျွန်ုပ်တို့အကြောင်း',
      path: '/about',
      icon: Info
    },
    {
      name: 'Contact',
      nameMM: 'ဆက်သွယ်ရန်',
      path: '/contact',
      icon: Mail
    }
  ];

  const quickLinks = [
    {
      name: 'iPhone',
      nameMM: 'အိုင်ဖုန်း',
      path: '/category/ios-phones',
      icon: Apple,
      categoryId: 4
    },
    {
      name: 'Android',
      nameMM: 'အန်းဒရွိုက်',
      path: '/category/android-phones',
      icon: Smartphone,
      categoryId: 3
    },
    {
      name: 'Accessories',
      nameMM: 'အပိုပစ္စည်းများ',
      path: '/category/accessories',
      icon: ShoppingBag,
      categoryId: 5
    },
    {
      name: 'Repair Service',
      nameMM: 'ပြင်ဆင်ရေးဝန်ဆောင်မှု',
      path: '/repair',
      icon: Wrench
    }
  ];

  const contactInfo = {
    phone: '+95 9 123 456 789',
    email: 'info@primemobile.com',
    address: 'Mandalay, Myanmar'
  };

  return (
    <>
      {/* Overlay */}
      {isOpen && (
        <div 
          className="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
          onClick={onClose}
        />
      )}

      {/* Sidebar */}
      <div className={`fixed top-0 left-0 h-full w-72 sm:w-80 bg-gray-900 shadow-2xl z-50 transform transition-all duration-300 ease-in-out lg:translate-x-0 border-r border-yellow-500/30 ${
        isOpen ? 'translate-x-0' : '-translate-x-full'
      }`}>
        {/* Sidebar Header */}
        <div className="flex items-center justify-between p-4 sm:p-6 border-b border-yellow-500/30">
          <div className="flex items-center space-x-3">
            <img 
              src={logo} 
              alt="Prime Mobile Logo" 
              className="w-10 h-10 rounded-xl object-cover shadow-lg"
            />
            <div>
              <h2 className="text-xl font-bold text-white font-gaming">Prime Mobile</h2>
              <p className="text-xs text-yellow-400 font-medium">Premium Mobile Store</p>
            </div>
          </div>
          <button
            onClick={onClose}
            className="lg:hidden p-2 text-yellow-400 hover:text-yellow-300 hover:bg-gray-800 rounded-lg transition-colors duration-200"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        {/* Navigation */}
        <div className="flex-1 overflow-y-auto">
          <nav className="p-4 sm:p-6">
            <div className="space-y-2">
              <h3 className="text-xs font-semibold text-yellow-400 uppercase tracking-wider mb-4 flex items-center">
                <span className="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                Main Navigation
              </h3>
              {navigationItems.map((item) => {
                const Icon = item.icon;
                const isActive = location.pathname === item.path;
                
                return (
                  <Link
                    key={item.path}
                    to={item.path}
                    onClick={onClose}
                    className={`flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 ${
                      isActive 
                        ? 'bg-yellow-500/20 text-yellow-300 border-r-4 border-yellow-500 shadow-sm' 
                        : 'text-gray-300 hover:bg-gray-800 hover:text-yellow-400'
                    }`}
                  >
                    <Icon className="w-5 h-5" />
                    <span className="font-medium">{item.name}</span>
                  </Link>
                );
              })}
            </div>

            {/* Quick Links */}
            <div className="mt-8">
              <h3 className="text-xs font-semibold text-yellow-400 uppercase tracking-wider mb-4 flex items-center">
                <span className="w-2 h-2 bg-yellow-600 rounded-full mr-2"></span>
                Quick Links
              </h3>
              <div className="space-y-2">
                {quickLinks.map((link) => {
                  const LinkIcon = link.icon;
                  return (
                    <Link
                      key={link.path}
                      to={link.path}
                      onClick={onClose}
                      className="flex items-center space-x-3 px-4 py-2 text-gray-400 hover:text-yellow-400 hover:bg-gray-800 rounded-lg transition-all duration-200 font-medium"
                    >
                      {LinkIcon && <LinkIcon className="w-4 h-4" />}
                      <span>{link.name}</span>
                    </Link>
                  );
                })}
              </div>
            </div>

            {/* Contact Info */}
            <div className="mt-8 p-4 bg-gradient-to-br from-gray-800 to-gray-700 rounded-xl border border-yellow-500/30">
              <h3 className="text-sm font-semibold text-white mb-3 flex items-center">
                <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Contact Information
              </h3>
              <div className="space-y-3 text-sm text-gray-300">
                <div className="flex items-center space-x-3">
                  <div className="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                    <Phone className="w-4 h-4 text-yellow-400" />
                  </div>
                  <span className="font-medium">{contactInfo.phone}</span>
                </div>
                <div className="flex items-center space-x-3">
                  <div className="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                    <Mail className="w-4 h-4 text-yellow-400" />
                  </div>
                  <span className="font-medium">{contactInfo.email}</span>
                </div>
                <div className="text-xs text-gray-400 mt-2 pl-11">
                  {contactInfo.address}
                </div>
              </div>
            </div>
          </nav>
        </div>

        {/* Sidebar Footer */}
        <div className="p-4 sm:p-6 border-t border-yellow-500/30 bg-gray-800">
          <div className="text-center">
            <p className="text-xs text-gray-400 mb-2">
              © 2025 Prime Mobile Shop
            </p>
            <p className="text-xs text-gray-500 flex items-center justify-center space-x-1">
              <span>Made with</span>
              <Heart className="w-3 h-3 text-red-500 fill-current" />
              <span>in Myanmar</span>
            </p>
          </div>
        </div>
      </div>
    </>
  );
};

export default Sidebar;