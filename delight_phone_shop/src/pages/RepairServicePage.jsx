import React, { useState } from 'react';
import { 
  Wrench, 
  Shield, 
  Clock, 
  CheckCircle, 
  Star,
  DollarSign,
  Phone,
  Mail,
  MapPin,
  Calendar,
  Smartphone,
  Battery,
  Wifi,
  Volume2,
  Camera,
  Settings
} from 'lucide-react';

const RepairServicePage = () => {
  const [selectedService, setSelectedService] = useState(null);

  const services = [
    {
      id: 1,
      name: 'Screen Replacement',
      icon: Smartphone,
      description: 'Professional LCD/OLED screen replacement for all phone models',
      price: 'From $50',
      duration: '30-60 mins',
      warranty: '90 Days'
    },
    {
      id: 2,
      name: 'Battery Replacement',
      icon: Battery,
      description: 'Original or high-quality battery replacement to extend phone life',
      price: 'From $30',
      duration: '20-30 mins',
      warranty: '180 Days'
    },
    {
      id: 3,
      name: 'Water Damage Repair',
      icon: Wifi,
      description: 'Complete water damage assessment and repair services',
      price: 'From $80',
      duration: '2-4 hours',
      warranty: '60 Days'
    },
    {
      id: 4,
      name: 'Charging Port Repair',
      icon: Settings,
      description: 'Fix charging port issues and connectivity problems',
      price: 'From $40',
      duration: '30-45 mins',
      warranty: '90 Days'
    },
    {
      id: 5,
      name: 'Speaker/Microphone Repair',
      icon: Volume2,
      description: 'Audio system repair for speakers and microphones',
      price: 'From $35',
      duration: '30-45 mins',
      warranty: '90 Days'
    },
    {
      id: 6,
      name: 'Camera Repair',
      icon: Camera,
      description: 'Front and back camera repair or replacement',
      price: 'From $60',
      duration: '1-2 hours',
      warranty: '90 Days'
    }
  ];

  const features = [
    {
      icon: Shield,
      title: 'Certified Technicians',
      description: 'Our expert technicians are certified and experienced in repairing all phone brands'
    },
    {
      icon: Clock,
      title: 'Quick Turnaround',
      description: 'Most repairs completed within 1 hour while you wait'
    },
    {
      icon: CheckCircle,
      title: 'Quality Parts',
      description: 'We use only original or premium quality replacement parts'
    },
    {
      icon: Star,
      title: 'Warranty Included',
      description: 'All repairs come with our comprehensive warranty coverage'
    }
  ];

  const process = [
    {
      step: '01',
      title: 'Diagnosis',
      description: 'Free diagnostic assessment of your device issue'
    },
    {
      step: '02',
      title: 'Quote',
      description: 'Transparent pricing with no hidden fees'
    },
    {
      step: '03',
      title: 'Repair',
      description: 'Professional repair by certified technicians'
    },
    {
      step: '04',
      title: 'Testing',
      description: 'Quality check and testing before return'
    }
  ];

  return (
    <div className="min-h-screen bg-gray-900">
      {/* Hero Section */}
      <div className="bg-gradient-to-r from-yellow-500 to-yellow-600 py-16">
        <div className="max-w-7xl mx-auto px-4">
          <div className="text-center">
            <div className="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-6">
              <Wrench className="w-10 h-10 text-yellow-600" />
            </div>
            <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
              Professional Phone Repair Services
            </h1>
            <p className="text-xl text-gray-800 max-w-3xl mx-auto">
              Fast, reliable, and affordable phone repair services with warranty. 
              Get your device fixed by certified technicians today!
            </p>
            <div className="mt-8 flex flex-wrap justify-center gap-4">
              <a href="#services" className="bg-gray-900 text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-800 transition-colors">
                View Services
              </a>
              <a href="#contact" className="border-2 border-gray-900 text-gray-900 px-8 py-3 rounded-xl font-semibold hover:bg-gray-900 hover:text-white transition-colors">
                Book Repair
              </a>
            </div>
          </div>
        </div>
      </div>

      {/* Features Section */}
      <div className="py-16 bg-gray-800">
        <div className="max-w-7xl mx-auto px-4">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {features.map((feature, index) => {
              const Icon = feature.icon;
              return (
                <div key={index} className="text-center">
                  <div className="inline-flex items-center justify-center w-16 h-16 bg-yellow-500/20 rounded-full mb-4">
                    <Icon className="w-8 h-8 text-yellow-400" />
                  </div>
                  <h3 className="text-xl font-bold text-white mb-2">{feature.title}</h3>
                  <p className="text-gray-400">{feature.description}</p>
                </div>
              );
            })}
          </div>
        </div>
      </div>

      {/* Services Section */}
      <div id="services" className="py-16">
        <div className="max-w-7xl mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
              Our Repair Services
            </h2>
            <p className="text-xl text-gray-400">
              Comprehensive repair solutions for all your phone needs
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {services.map((service) => {
              const ServiceIcon = service.icon;
              return (
                <div 
                  key={service.id}
                  className="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-yellow-500 transition-all duration-300 cursor-pointer group"
                  onClick={() => setSelectedService(service)}
                >
                  <div className="flex items-start space-x-4">
                    <div className="bg-yellow-500/20 p-3 rounded-lg group-hover:bg-yellow-500/30 transition-colors">
                      <ServiceIcon className="w-8 h-8 text-yellow-400" />
                    </div>
                    <div className="flex-1">
                      <h3 className="text-xl font-bold text-white mb-2">{service.name}</h3>
                      <p className="text-gray-400 text-sm mb-4">{service.description}</p>
                      
                      <div className="space-y-2">
                        <div className="flex items-center text-sm">
                          <DollarSign className="w-4 h-4 text-green-400 mr-2" />
                          <span className="text-gray-300">{service.price}</span>
                        </div>
                        <div className="flex items-center text-sm">
                          <Clock className="w-4 h-4 text-blue-400 mr-2" />
                          <span className="text-gray-300">{service.duration}</span>
                        </div>
                        <div className="flex items-center text-sm">
                          <Shield className="w-4 h-4 text-yellow-400 mr-2" />
                          <span className="text-gray-300">{service.warranty} Warranty</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </div>

      {/* Process Section */}
      <div className="py-16 bg-gray-800">
        <div className="max-w-7xl mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
              How It Works
            </h2>
            <p className="text-xl text-gray-400">
              Simple and transparent repair process
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {process.map((item, index) => (
              <div key={index} className="relative">
                <div className="bg-gray-900 rounded-xl p-6 border border-gray-700">
                  <div className="text-5xl font-bold text-yellow-500/20 mb-4">{item.step}</div>
                  <h3 className="text-xl font-bold text-white mb-2">{item.title}</h3>
                  <p className="text-gray-400">{item.description}</p>
                </div>
                {index < process.length - 1 && (
                  <div className="hidden lg:block absolute top-1/2 -right-3 transform -translate-y-1/2">
                    <div className="w-6 h-0.5 bg-yellow-500"></div>
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* Contact Section */}
      <div id="contact" className="py-16">
        <div className="max-w-7xl mx-auto px-4">
          <div className="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-8 md:p-12">
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <div>
                <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                  Book Your Repair Today
                </h2>
                <p className="text-gray-800 mb-6">
                  Get in touch with us to schedule your phone repair. Walk-ins welcome!
                </p>
                
                <div className="space-y-4">
                  <div className="flex items-center space-x-3">
                    <div className="bg-gray-900 p-3 rounded-lg">
                      <Phone className="w-6 h-6 text-yellow-400" />
                    </div>
                    <div>
                      <p className="text-sm text-gray-700">Call Us</p>
                      <p className="font-semibold text-gray-900">+95 9 123 456 789</p>
                    </div>
                  </div>
                  
                  <div className="flex items-center space-x-3">
                    <div className="bg-gray-900 p-3 rounded-lg">
                      <Mail className="w-6 h-6 text-yellow-400" />
                    </div>
                    <div>
                      <p className="text-sm text-gray-700">Email Us</p>
                      <p className="font-semibold text-gray-900">repair@primemobile.com</p>
                    </div>
                  </div>
                  
                  <div className="flex items-center space-x-3">
                    <div className="bg-gray-900 p-3 rounded-lg">
                      <MapPin className="w-6 h-6 text-yellow-400" />
                    </div>
                    <div>
                      <p className="text-sm text-gray-700">Visit Us</p>
                      <p className="font-semibold text-gray-900">Downtown, Yangon, Myanmar</p>
                    </div>
                  </div>

                  <div className="flex items-center space-x-3">
                    <div className="bg-gray-900 p-3 rounded-lg">
                      <Clock className="w-6 h-6 text-yellow-400" />
                    </div>
                    <div>
                      <p className="text-sm text-gray-700">Working Hours</p>
                      <p className="font-semibold text-gray-900">Mon-Sat: 9AM - 8PM</p>
                    </div>
                  </div>
                </div>
              </div>

              <div className="bg-white rounded-xl p-6">
                <h3 className="text-2xl font-bold text-gray-900 mb-6">Request a Quote</h3>
                <form className="space-y-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                    <input 
                      type="text" 
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                      placeholder="John Doe"
                    />
                  </div>
                  
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input 
                      type="tel" 
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                      placeholder="+95 9 XXX XXX XXX"
                    />
                  </div>
                  
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Device Model</label>
                    <input 
                      type="text" 
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                      placeholder="iPhone 14 Pro"
                    />
                  </div>
                  
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Issue Description</label>
                    <textarea 
                      rows="3"
                      className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                      placeholder="Describe the problem..."
                    ></textarea>
                  </div>
                  
                  <button 
                    type="submit"
                    className="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition-colors"
                  >
                    Request Quote
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* FAQ Section */}
      <div className="py-16 bg-gray-800">
        <div className="max-w-7xl mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
              Frequently Asked Questions
            </h2>
          </div>

          <div className="max-w-3xl mx-auto space-y-4">
            {[
              {
                q: "Do you repair all phone brands?",
                a: "Yes, we repair all major brands including iPhone, Samsung, Google Pixel, OnePlus, and more."
              },
              {
                q: "How long does a typical repair take?",
                a: "Most repairs are completed within 1 hour. Complex repairs may take 2-4 hours."
              },
              {
                q: "Do you use original parts?",
                a: "We use original parts when available, or premium quality aftermarket parts with warranty."
              },
              {
                q: "What if my phone can't be repaired?",
                a: "We offer free diagnostics. If repair isn't possible, we'll recommend the best alternatives."
              }
            ].map((faq, index) => (
              <div key={index} className="bg-gray-900 rounded-lg p-6 border border-gray-700">
                <h3 className="text-lg font-bold text-white mb-2">{faq.q}</h3>
                <p className="text-gray-400">{faq.a}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default RepairServicePage;
