import axios from 'axios';

// Create axios instance with base configuration
const api = axios.create({
  baseURL: 'https://sales.primemobilemm.site/api', // Laravel server running on port 8000
  timeout: 30000, // Increased timeout to 30 seconds
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
});

// Request interceptor
api.interceptors.request.use(
  (config) => {
    // Add any auth tokens here if needed
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor
api.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    // Only log error if it's not a timeout (to avoid spam)
    if (error.code !== 'ECONNABORTED') {
      console.error('API Error:', error.response?.data || error.message);
    }
    
    // Return a mock response structure to prevent crashes
    return Promise.resolve({
      data: {
        status: 'Error has occured...',
        message: 'Failed to fetch data',
        data: []
      }
    });
  }
);

// API endpoints
export const apiService = {
  // Banner APIs
  getBanners: () => api.get('/banner'),
  getBannerText: () => api.get('/banner_Text'),
  getBannerAds: () => api.get('/popup-ads-banner'),
  getVideoAds: () => api.get('/videoads'),
  
  // Promotion APIs
  getPromotions: () => api.get('/promotion'),
  
  // Product Category APIs
  getCategories: () => api.get('/categories'),
  getAllCategories: () => api.get('/categories/all'),
  getCategoryById: (id) => api.get(`/categories/${id}`),
  
  // Product Status APIs
  getStatuses: () => api.get('/statuses'),
  getAvailableStatuses: () => api.get('/statuses/available'),
  
  // Product APIs
  getProducts: (params = {}) => api.get('/products', { params }),
  getProductById: (id) => api.get(`/products/${id}`),
  getFeaturedProducts: () => api.get('/products/featured'),
  getLatestProducts: () => api.get('/products/latest'),
  getBestSellers: () => api.get('/products/best-sellers'),
  getNewArrivals: () => api.get('/products/new-arrivals'),
  searchProducts: (params) => api.get('/products/search', { params }),
  getProductsByCategory: (categoryId) => api.get(`/products/category/${categoryId}`),
  
  // Voucher APIs
  getVoucherByCode: (voucherCode) => api.get(`/vouchers/${voucherCode}`),
  validateVoucher: (voucherCode) => api.get(`/vouchers/validate/${voucherCode}`),
  useVoucher: (data) => api.post('/vouchers/use', data),
  getCustomerVouchers: (customerId) => api.get(`/vouchers/customer/${customerId}`),
  getCustomerVoucherStats: (customerId) => api.get(`/vouchers/customer/${customerId}/stats`),
};

export default api;
