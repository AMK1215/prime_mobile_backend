import React from 'react';
import { Link } from 'react-router-dom';
import { Home, ArrowLeft, Search } from 'lucide-react';

const NotFoundPage = () => {
  return (
    <div className="min-h-screen bg-gray-50 flex items-center justify-center">
      <div className="text-center">
        <div className="mb-8">
          <h1 className="text-9xl font-bold text-gray-300">404</h1>
          <h2 className="text-3xl font-bold text-gray-800 mb-4">Page Not Found</h2>
          <p className="text-lg text-gray-600 max-w-md mx-auto">
            Sorry, the page you are looking for doesn't exist or has been moved.
          </p>
        </div>

        <div className="space-y-4">
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link to="/" className="btn btn-primary inline-flex items-center justify-center space-x-2">
              <Home className="w-5 h-5" />
              <span>Go Home</span>
            </Link>
            
            <button 
              onClick={() => window.history.back()}
              className="btn btn-outline inline-flex items-center justify-center space-x-2"
            >
              <ArrowLeft className="w-5 h-5" />
              <span>Go Back</span>
            </button>
          </div>

          <div className="mt-8">
            <p className="text-gray-500 mb-4">Or try searching for what you need:</p>
            <div className="flex max-w-md mx-auto">
              <input
                type="text"
                placeholder="Search products..."
                className="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
              <button className="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 transition-colors">
                <Search className="w-5 h-5" />
              </button>
            </div>
          </div>

          <div className="mt-8 text-sm text-gray-500">
            <p>Need help? <Link to="/contact" className="text-blue-600 hover:text-blue-800">Contact our support team</Link></p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default NotFoundPage;
