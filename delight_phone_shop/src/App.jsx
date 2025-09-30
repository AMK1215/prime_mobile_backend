import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

// Layout Component
import Layouts from './components/Layouts';

// Pages
import HomePage from './pages/HomePage';
import ProductsPage from './pages/ProductsPage';
import ProductDetailPage from './pages/ProductDetailPage';
import FeaturedPage from './pages/FeaturedPage';
import BestSellersPage from './pages/BestSellersPage';
import NewArrivalsPage from './pages/NewArrivalsPage';
import CategoryPage from './pages/CategoryPage';
import CategoriesPage from './pages/CategoriesPage';
import RepairServicePage from './pages/RepairServicePage';
import FAQPage from './pages/FAQPage';
import AboutPage from './pages/AboutPage';
import ContactPage from './pages/ContactPage';
import ProductManagementPage from './pages/ProductManagementPage';
import WarrantyPage from './pages/WarrantyPage';
import VoucherPage from './pages/VoucherPage';
import NotFoundPage from './pages/NotFoundPage';

function App() {
  return (
    <Router>
      <Layouts>
        <Routes>
          {/* Home Page */}
          <Route path="/" element={<HomePage />} />
          
          {/* Products */}
          <Route path="/products" element={<ProductsPage />} />
          <Route path="/products/:id" element={<ProductDetailPage />} />
          <Route path="/featured" element={<FeaturedPage />} />
          <Route path="/best-sellers" element={<BestSellersPage />} />
          <Route path="/new-arrivals" element={<NewArrivalsPage />} />
          
          {/* Categories */}
          <Route path="/categories" element={<CategoriesPage />} />
          <Route path="/category/:categorySlug" element={<CategoryPage />} />
          <Route path="/products/category/:categoryId" element={<ProductsPage />} />
          
          {/* Other Pages */}
          <Route path="/repair" element={<RepairServicePage />} />
          <Route path="/faq" element={<FAQPage />} />
          <Route path="/about" element={<AboutPage />} />
          <Route path="/contact" element={<ContactPage />} />
          
              {/* Admin/Management Pages */}
              <Route path="/admin/products" element={<ProductManagementPage />} />
              
              {/* Warranty Pages */}
              <Route path="/customer/:customerId" element={<WarrantyPage />} />
              
              {/* Voucher Pages */}
              <Route path="/voucher/:voucherCode" element={<VoucherPage />} />
          
          {/* 404 Page */}
          <Route path="*" element={<NotFoundPage />} />
        </Routes>
      </Layouts>
    </Router>
  );
}

export default App;