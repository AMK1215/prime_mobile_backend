import React from 'react';
import { Star, Shield, Truck } from 'lucide-react';

const FeaturesSection = () => {
  const features = [
    {
      icon: Star,
      title: 'Premium Quality',
      description: 'Only genuine products with warranty',
      gradient: 'from-orange-400 to-yellow-500'
    },
    {
      icon: Shield,
      title: 'Secure Shopping',
      description: 'Safe and secure online transactions',
      gradient: 'from-green-400 to-teal-500'
    },
    {
      icon: Truck,
      title: 'Fast Delivery',
      description: 'Quick delivery across Myanmar',
      gradient: 'from-blue-400 to-cyan-500'
    }
  ];

  return (
    <div className="py-16 bg-gradient-to-r from-gray-100 via-white to-gray-100">
      <div className="container-custom">
        <div className="flex flex-col md:flex-row items-center justify-between space-y-8 md:space-y-0 md:space-x-8">
          {features.map((feature, index) => {
            const Icon = feature.icon;
            return (
              <div key={index} className="flex flex-col items-center text-center max-w-xs">
                {/* Icon */}
                <div className={`w-16 h-16 rounded-2xl bg-gradient-to-r ${feature.gradient} flex items-center justify-center mb-4 shadow-lg`}>
                  <Icon className="w-8 h-8 text-white" />
                </div>
                
                {/* Title */}
                <h3 className="text-xl font-bold text-gray-700 mb-2">
                  {feature.title}
                </h3>
                
                {/* Description */}
                <p className="text-gray-500 text-sm leading-relaxed">
                  {feature.description}
                </p>
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );
};

export default FeaturesSection;
