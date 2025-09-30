import React, { useState } from 'react';
import { 
  ChevronDown, 
  ChevronUp, 
  HelpCircle,
  Package,
  CreditCard,
  Truck,
  RefreshCw,
  Shield,
  Phone,
  MessageCircle,
  Search,
  Mail
} from 'lucide-react';

const FAQPage = () => {
  const [openItems, setOpenItems] = useState([0]); // First item open by default
  const [searchTerm, setSearchTerm] = useState('');

  const toggleItem = (index) => {
    setOpenItems(prev => 
      prev.includes(index) 
        ? prev.filter(i => i !== index)
        : [...prev, index]
    );
  };

  const faqCategories = [
    {
      title: 'General Questions',
      icon: HelpCircle,
      color: 'blue',
      questions: [
        {
          q: 'What are your store hours?',
          a: 'We are open Monday to Saturday from 9:00 AM to 8:00 PM, and Sunday from 10:00 AM to 6:00 PM. We also offer online shopping 24/7 through our website.'
        },
        {
          q: 'Where is your store located?',
          a: 'Our main store is located at 123 Mobile Street, Mandalay, Myanmar. We also have branches in Yangon and Naypyidaw. You can find exact locations on our Contact page.'
        },
        {
          q: 'Do you sell genuine products?',
          a: 'Yes, absolutely! All our products are 100% genuine and sourced directly from authorized distributors. We provide official warranty cards and certificates of authenticity with every purchase.'
        },
        {
          q: 'Can I order online and pick up in store?',
          a: 'Yes, we offer Click & Collect service. Simply order online and choose "Pick up in store" at checkout. We\'ll notify you when your order is ready for pickup, usually within 2-4 hours.'
        }
      ]
    },
    {
      title: 'Products & Pricing',
      icon: Package,
      color: 'green',
      questions: [
        {
          q: 'Are your prices negotiable?',
          a: 'Our prices are competitive and fair. While we don\'t typically negotiate on individual items, we offer bundle deals, trade-in programs, and seasonal promotions that can help you save money.'
        },
        {
          q: 'Do you have installment payment options?',
          a: 'Yes, we offer flexible installment plans through our partner banks. You can choose from 3, 6, or 12-month payment plans with competitive interest rates. Visit our store for more details.'
        },
        {
          q: 'What phones do you have in stock?',
          a: 'We carry a wide range of smartphones including the latest iPhone models, Samsung Galaxy series, Google Pixel, OnePlus, Xiaomi, OPPO, Vivo, and more. Check our Products page for real-time stock availability.'
        },
        {
          q: 'Can I pre-order upcoming phone models?',
          a: 'Yes! We accept pre-orders for upcoming flagship phones. Contact us or visit our store to reserve your device. We\'ll notify you as soon as the phone arrives.'
        }
      ]
    },
    {
      title: 'Payment & Checkout',
      icon: CreditCard,
      color: 'yellow',
      questions: [
        {
          q: 'What payment methods do you accept?',
          a: 'We accept cash, all major credit/debit cards (Visa, Mastercard, JCB), mobile payment apps (KBZPay, WavePay, AYA Pay), and bank transfers. Online payments are processed securely.'
        },
        {
          q: 'Is it safe to shop online on your website?',
          a: 'Absolutely! Our website uses SSL encryption to protect your personal and payment information. We never store your card details, and all transactions are processed through secure payment gateways.'
        },
        {
          q: 'Can I get an invoice for my purchase?',
          a: 'Yes, we provide detailed invoices for all purchases. You\'ll receive an email invoice immediately after purchase, and a printed invoice is included with your order.'
        },
        {
          q: 'Do you offer corporate/bulk pricing?',
          a: 'Yes, we offer special pricing for corporate clients and bulk orders (10+ units). Please contact our corporate sales team at corporate@primemobile.com for a customized quote.'
        }
      ]
    },
    {
      title: 'Shipping & Delivery',
      icon: Truck,
      color: 'purple',
      questions: [
        {
          q: 'Do you offer delivery service?',
          a: 'Yes, we offer delivery throughout Myanmar. Delivery is free for orders over 500,000 MMK in major cities (Yangon, Mandalay, Naypyidaw). Standard delivery takes 1-3 business days.'
        },
        {
          q: 'How much does shipping cost?',
          a: 'Shipping costs vary by location: Free for orders over 500,000 MMK in major cities, 5,000 MMK for orders under 500,000 MMK, and 10,000-15,000 MMK for remote areas.'
        },
        {
          q: 'Can I track my order?',
          a: 'Yes! Once your order is shipped, you\'ll receive a tracking number via SMS and email. You can track your order status in real-time on our website.'
        },
        {
          q: 'What if I\'m not home during delivery?',
          a: 'Our delivery partner will call you 30 minutes before arrival. If you\'re unavailable, they can reschedule delivery or leave the package with a trusted neighbor with your permission.'
        }
      ]
    },
    {
      title: 'Returns & Exchanges',
      icon: RefreshCw,
      color: 'red',
      questions: [
        {
          q: 'What is your return policy?',
          a: 'We offer a 7-day return policy for unopened products in original packaging. The product must be unused with all accessories and documentation. Refunds are processed within 5-7 business days.'
        },
        {
          q: 'Can I exchange my phone for a different model?',
          a: 'Yes, exchanges are allowed within 7 days of purchase. The phone must be in original condition. If there\'s a price difference, you can pay or receive the difference.'
        },
        {
          q: 'What if I receive a defective product?',
          a: 'If you receive a defective product, contact us immediately. We\'ll replace it free of charge or provide a full refund. Defective items can be returned within 30 days.'
        },
        {
          q: 'Do I need to pay for return shipping?',
          a: 'Return shipping is free if the product is defective or if we made an error. For other returns (change of mind, wrong model ordered), return shipping costs apply.'
        }
      ]
    },
    {
      title: 'Warranty & Repairs',
      icon: Shield,
      color: 'indigo',
      questions: [
        {
          q: 'What warranty do you offer?',
          a: 'All our phones come with manufacturer\'s warranty (usually 1 year). We also offer extended warranty plans for additional coverage. Warranty details vary by brand and model.'
        },
        {
          q: 'Do you repair phones?',
          a: 'Yes! We have a professional repair service for all phone brands. Services include screen replacement, battery replacement, water damage repair, and more. Most repairs are completed within 1 hour.'
        },
        {
          q: 'How do I claim warranty?',
          a: 'To claim warranty, bring your phone along with the warranty card and purchase receipt to our store. Our technicians will assess the issue and process your warranty claim accordingly.'
        },
        {
          q: 'Does warranty cover accidental damage?',
          a: 'Standard warranty covers manufacturing defects only. Accidental damage, water damage, and physical damage are not covered. However, you can purchase our extended protection plan that covers these.'
        }
      ]
    },
    {
      title: 'Trade-in & Upgrade',
      icon: RefreshCw,
      color: 'orange',
      questions: [
        {
          q: 'Do you accept trade-ins?',
          a: 'Yes! We accept trade-ins for most smartphone brands in working condition. Bring your old phone to our store for a free evaluation and get instant credit towards a new purchase.'
        },
        {
          q: 'How is the trade-in value determined?',
          a: 'Trade-in value depends on the phone model, age, condition, and current market value. Our experts will thoroughly inspect your device and offer a fair market price.'
        },
        {
          q: 'Can I trade in a damaged phone?',
          a: 'Yes, we accept damaged phones too, though the trade-in value will be lower depending on the damage. We evaluate each device individually to provide the best possible offer.'
        },
        {
          q: 'Do I need to factory reset my old phone?',
          a: 'Yes, please backup your data and perform a factory reset before trading in. Our staff can help you with the process if needed. We also ensure all data is securely wiped.'
        }
      ]
    },
    {
      title: 'Technical Support',
      icon: MessageCircle,
      color: 'teal',
      questions: [
        {
          q: 'How can I contact customer support?',
          a: 'You can reach us via phone (+95 9 123 456 789), email (support@primemobile.com), or visit our store. We also offer live chat support on our website during business hours.'
        },
        {
          q: 'Do you provide phone setup assistance?',
          a: 'Yes! We offer free phone setup assistance with every purchase. Our staff will help you transfer data, set up apps, and answer any questions about your new device.'
        },
        {
          q: 'Can you help with data transfer?',
          a: 'Absolutely! We provide complimentary data transfer service when you purchase a new phone. We can transfer contacts, photos, apps, and other data from your old device.'
        },
        {
          q: 'Do you unlock phones?',
          a: 'We can assist with unlocking phones that are eligible for unlocking. Network-locked phones must meet the carrier\'s unlocking criteria. Contact us for specific phone unlocking inquiries.'
        }
      ]
    }
  ];

  // Flatten all questions for search
  const allQuestions = faqCategories.flatMap((category, catIndex) =>
    category.questions.map((q, qIndex) => ({
      ...q,
      categoryIndex: catIndex,
      questionIndex: qIndex,
      category: category.title,
      color: category.color
    }))
  );

  // Filter questions based on search
  const filteredQuestions = allQuestions.filter(item =>
    item.q.toLowerCase().includes(searchTerm.toLowerCase()) ||
    item.a.toLowerCase().includes(searchTerm.toLowerCase()) ||
    item.category.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const colorClasses = {
    blue: 'from-blue-500 to-blue-600',
    green: 'from-green-500 to-green-600',
    yellow: 'from-yellow-500 to-yellow-600',
    purple: 'from-purple-500 to-purple-600',
    red: 'from-red-500 to-red-600',
    indigo: 'from-indigo-500 to-indigo-600',
    orange: 'from-orange-500 to-orange-600',
    teal: 'from-teal-500 to-teal-600'
  };

  return (
    <div className="min-h-screen bg-gray-900">
      {/* Hero Section */}
      <div className="bg-gradient-to-r from-yellow-500 to-yellow-600 py-16">
        <div className="max-w-7xl mx-auto px-4">
          <div className="text-center">
            <div className="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-6">
              <HelpCircle className="w-10 h-10 text-yellow-600" />
            </div>
            <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
              Frequently Asked Questions
            </h1>
            <p className="text-xl text-gray-800 max-w-3xl mx-auto">
              Find answers to common questions about our products, services, and policies
            </p>
          </div>
        </div>
      </div>

      {/* Search Bar */}
      <div className="max-w-7xl mx-auto px-4 -mt-8">
        <div className="bg-gray-800 rounded-xl shadow-2xl p-6 border border-gray-700">
          <div className="relative">
            <Search className="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
            <input
              type="text"
              placeholder="Search for answers..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              className="w-full pl-12 pr-4 py-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent placeholder-gray-400 text-lg"
            />
          </div>
          {searchTerm && (
            <p className="mt-3 text-sm text-gray-400">
              Found {filteredQuestions.length} result{filteredQuestions.length !== 1 ? 's' : ''} for "{searchTerm}"
            </p>
          )}
        </div>
      </div>

      {/* FAQ Content */}
      <div className="max-w-7xl mx-auto px-4 py-12">
        {searchTerm ? (
          // Search Results
          <div className="space-y-4">
            {filteredQuestions.length > 0 ? (
              filteredQuestions.map((item, index) => {
                const isOpen = openItems.includes(`search-${index}`);
                return (
                  <div key={index} className="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <button
                      onClick={() => toggleItem(`search-${index}`)}
                      className="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-700/50 transition-colors"
                    >
                      <div className="flex items-start space-x-4 text-left flex-1">
                        <HelpCircle className="w-5 h-5 text-yellow-400 mt-1 flex-shrink-0" />
                        <div className="flex-1">
                          <h3 className="text-lg font-semibold text-white mb-1">{item.q}</h3>
                          <p className="text-sm text-gray-400">{item.category}</p>
                        </div>
                      </div>
                      {isOpen ? (
                        <ChevronUp className="w-5 h-5 text-yellow-400 flex-shrink-0" />
                      ) : (
                        <ChevronDown className="w-5 h-5 text-gray-400 flex-shrink-0" />
                      )}
                    </button>
                    {isOpen && (
                      <div className="px-6 pb-6 pt-2">
                        <div className="pl-9 text-gray-300 leading-relaxed">
                          {item.a}
                        </div>
                      </div>
                    )}
                  </div>
                );
              })
            ) : (
              <div className="text-center py-12">
                <Search className="w-16 h-16 text-gray-600 mx-auto mb-4" />
                <h3 className="text-xl font-semibold text-white mb-2">No Results Found</h3>
                <p className="text-gray-400">Try searching with different keywords</p>
              </div>
            )}
          </div>
        ) : (
          // Category View
          <div className="space-y-8">
            {faqCategories.map((category, catIndex) => {
              const CategoryIcon = category.icon;
              const gradientClass = colorClasses[category.color];
              
              return (
                <div key={catIndex} className="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                  <div className={`bg-gradient-to-r ${gradientClass} px-6 py-4`}>
                    <div className="flex items-center space-x-3">
                      <CategoryIcon className="w-6 h-6 text-white" />
                      <h2 className="text-2xl font-bold text-white">{category.title}</h2>
                    </div>
                  </div>
                  
                  <div className="divide-y divide-gray-700">
                    {category.questions.map((item, qIndex) => {
                      const itemIndex = `${catIndex}-${qIndex}`;
                      const isOpen = openItems.includes(itemIndex);
                      
                      return (
                        <div key={qIndex}>
                          <button
                            onClick={() => toggleItem(itemIndex)}
                            className="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-700/50 transition-colors"
                          >
                            <h3 className="text-lg font-semibold text-white text-left pr-4">{item.q}</h3>
                            {isOpen ? (
                              <ChevronUp className="w-5 h-5 text-yellow-400 flex-shrink-0" />
                            ) : (
                              <ChevronDown className="w-5 h-5 text-gray-400 flex-shrink-0" />
                            )}
                          </button>
                          {isOpen && (
                            <div className="px-6 pb-6 pt-2 bg-gray-700/30">
                              <p className="text-gray-300 leading-relaxed">{item.a}</p>
                            </div>
                          )}
                        </div>
                      );
                    })}
                  </div>
                </div>
              );
            })}
          </div>
        )}
      </div>

      {/* Contact CTA */}
      <div className="max-w-7xl mx-auto px-4 pb-16">
        <div className="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-8 md:p-12 text-center">
          <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Still Have Questions?
          </h2>
          <p className="text-xl text-gray-800 mb-8">
            Our customer support team is here to help you
          </p>
          
          <div className="flex flex-wrap justify-center gap-4">
            <a 
              href="/contact" 
              className="bg-gray-900 text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-800 transition-colors inline-flex items-center space-x-2"
            >
              <Mail className="w-5 h-5" />
              <span>Contact Us</span>
            </a>
            <a 
              href="tel:+959123456789" 
              className="border-2 border-gray-900 text-gray-900 px-8 py-3 rounded-xl font-semibold hover:bg-gray-900 hover:text-white transition-colors inline-flex items-center space-x-2"
            >
              <Phone className="w-5 h-5" />
              <span>Call Now</span>
            </a>
          </div>
          
          <div className="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
            <div className="bg-white/20 rounded-lg p-4">
              <Phone className="w-8 h-8 text-gray-900 mx-auto mb-2" />
              <p className="text-sm font-medium text-gray-900">Phone Support</p>
              <p className="text-sm text-gray-800">+95 9 123 456 789</p>
            </div>
            <div className="bg-white/20 rounded-lg p-4">
              <Mail className="w-8 h-8 text-gray-900 mx-auto mb-2" />
              <p className="text-sm font-medium text-gray-900">Email Support</p>
              <p className="text-sm text-gray-800">support@primemobile.com</p>
            </div>
            <div className="bg-white/20 rounded-lg p-4">
              <MessageCircle className="w-8 h-8 text-gray-900 mx-auto mb-2" />
              <p className="text-sm font-medium text-gray-900">Live Chat</p>
              <p className="text-sm text-gray-800">Available 9AM - 8PM</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default FAQPage;
