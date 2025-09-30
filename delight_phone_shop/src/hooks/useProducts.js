import { useState, useEffect } from 'react';
import { apiService } from '../services/api';

export const useProducts = (type = 'all', options = {}) => {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    // Add a small delay to prevent overwhelming the API
    const timer = setTimeout(() => {
      fetchProducts();
    }, 100);
    
    return () => clearTimeout(timer);
  }, [type, JSON.stringify(options)]);

  const fetchProducts = async () => {
    try {
      setLoading(true);
      setError(null);

      let response;

      console.log('Fetching products - Type:', type, 'Options:', options);

      switch (type) {
        case 'featured':
          response = await apiService.getFeaturedProducts();
          break;
        case 'latest':
          response = await apiService.getLatestProducts();
          break;
        case 'best-sellers':
          response = await apiService.getBestSellers();
          break;
        case 'new-arrivals':
          response = await apiService.getNewArrivals();
          break;
        case 'search':
          response = await apiService.searchProducts(options);
          break;
        case 'category':
          response = await apiService.getProductsByCategory(options.categoryId);
          break;
        default:
          response = await apiService.getProducts(options);
      }

      console.log('API Response:', response?.data);

      if (response?.data?.status === 'Request was successful.' && response?.data?.data) {
        if (type === 'category') {
          setProducts(response.data.data.products || []);
        } else if (Array.isArray(response.data.data)) {
          setProducts(response.data.data);
        } else if (response.data.data.products) {
          setProducts(response.data.data.products);
        } else {
          setProducts([]);
        }
        console.log('Products set:', response.data.data);
      } else {
        console.log('No valid data in response');
        setProducts([]);
      }
    } catch (err) {
      console.error('Error fetching products:', err);
      setError('Failed to load products');
      setProducts([]);
    } finally {
      setLoading(false);
    }
  };

  const refetch = () => {
    fetchProducts();
  };

  return {
    products,
    loading,
    error,
    refetch
  };
};

export const useProduct = (productId) => {
  const [product, setProduct] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (productId) {
      // Add a small delay to prevent overwhelming the API
      const timer = setTimeout(() => {
        fetchProduct();
      }, 100);
      
      return () => clearTimeout(timer);
    }
  }, [productId]);

  const fetchProduct = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await apiService.getProductById(productId);

      if (response?.data?.status === 'Request was successful.' && response?.data?.data) {
        setProduct(response.data.data);
      } else {
        setError('Product not found');
        setProduct(null);
      }
    } catch (err) {
      console.error('Error fetching product:', err);
      setError('Failed to load product');
      setProduct(null);
    } finally {
      setLoading(false);
    }
  };

  return {
    product,
    loading,
    error,
    refetch: fetchProduct
  };
};
