import React, { useState } from 'react';
import { Toaster } from 'react-hot-toast';

// Layout Components
import Navbar from './Navbar';
import Sidebar from './Sidebar';
import Footer from './Footer';
import BannerAds from './BannerAds';

const Layouts = ({ children }) => {
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);

  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  const closeSidebar = () => {
    setIsSidebarOpen(false);
  };

  return (
    <div className="min-h-screen bg-gray-900 text-white flex flex-col">
      {/* Toast Notifications */}
      <Toaster
        position="top-right"
        toastOptions={{
          duration: 4000,
          style: {
            background: 'rgba(15, 20, 25, 0.95)',
            color: '#fbbf24',
            backdropFilter: 'blur(10px)',
            borderRadius: '12px',
            border: '1px solid rgba(251, 191, 36, 0.3)',
            boxShadow: '0 10px 40px -10px rgba(0, 0, 0, 0.15)',
          },
          success: {
            duration: 3000,
            style: {
              background: 'rgba(34, 197, 94, 0.95)',
              color: '#fff',
            },
            iconTheme: {
              primary: '#fff',
              secondary: '#22c55e',
            },
          },
          error: {
            duration: 5000,
            style: {
              background: 'rgba(239, 68, 68, 0.95)',
              color: '#fff',
            },
            iconTheme: {
              primary: '#fff',
              secondary: '#ef4444',
            },
          },
        }}
      />

      {/* Navbar */}
      <Navbar 
        onToggleSidebar={toggleSidebar}
        isSidebarOpen={isSidebarOpen}
      />

      {/* Sidebar */}
      <Sidebar 
        isOpen={isSidebarOpen}
        onClose={closeSidebar}
      />

      {/* Main Content Area */}
      <main className="flex-1 relative">
        {/* Content Container */}
        <div className="min-h-full">
          {children}
        </div>
      </main>

      {/* Footer */}
      <Footer />

      {/* Banner Ads Popup */}
      <BannerAds />
    </div>
  );
};

export default Layouts;
