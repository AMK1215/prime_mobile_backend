import React from 'react';
import { Star, TrendingUp, Award, Zap } from 'lucide-react';

const StatsSection = () => {
  const stats = [
    {
      icon: Star,
      metric: '10,000+',
      description: 'Happy Customers',
      gradient: 'from-orange-400 to-yellow-500'
    },
    {
      icon: TrendingUp,
      metric: '500+',
      description: 'Products Sold',
      gradient: 'from-green-400 to-green-600'
    },
    {
      icon: Award,
      metric: '50+',
      description: 'Brands Available',
      gradient: 'from-blue-400 to-cyan-500'
    },
    {
      icon: Zap,
      metric: '24/7',
      description: 'Customer Support',
      gradient: 'from-purple-400 to-pink-500'
    }
  ];

  return (
    <div className="py-16 bg-gray-900">
      <div className="container-custom">
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-6">
          {stats.map((stat, index) => {
            const Icon = stat.icon;
            return (
              <div key={index} className="text-center">
                {/* Icon */}
                <div className={`w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-r ${stat.gradient} flex items-center justify-center shadow-lg`}>
                  <Icon className="w-8 h-8 text-white" />
                </div>
                
                {/* Metric */}
                <div className="text-3xl font-bold text-white mb-2">
                  {stat.metric}
                </div>
                
                {/* Description */}
                <div className="text-gray-400 text-sm">
                  {stat.description}
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );
};

export default StatsSection;
