import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { 
  Shield, 
  Smartphone, 
  Calendar, 
  User, 
  DollarSign, 
  MapPin, 
  Phone, 
  Mail,
  CheckCircle,
  XCircle,
  Clock,
  Package,
  Store
} from 'lucide-react';
import api from '../services/api';

const WarrantyPage = () => {
  const { customerId } = useParams();
  const [warrantyData, setWarrantyData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchWarrantyData = async () => {
      try {
        setLoading(true);
        const response = await api.get(`/warranty/customer/${customerId}`);
        setWarrantyData(response.data.data);
        setError(null);
      } catch (err) {
        setError(err.response?.data?.message || 'Failed to load warranty information');
      } finally {
        setLoading(false);
      }
    };

    if (customerId) {
      fetchWarrantyData();
    }
  }, [customerId]);

  if (loading) {
    return (
      <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Loading warranty information...</p>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="min-h-screen bg-gradient-to-br from-red-50 to-pink-100 flex items-center justify-center">
        <div className="text-center max-w-md mx-auto p-6">
          <XCircle className="h-16 w-16 text-red-500 mx-auto mb-4" />
          <h1 className="text-2xl font-bold text-gray-900 mb-2">Warranty Not Found</h1>
          <p className="text-gray-600 mb-4">{error}</p>
          <p className="text-sm text-gray-500">
            Please check the QR code or contact our support team.
          </p>
        </div>
      </div>
    );
  }

  if (!warrantyData) {
    return null;
  }

  const { customer, product, sale, warranty, contact } = warrantyData;

  // Ensure all required data exists with fallbacks
  const safeSale = {
    price: Number(sale?.price || 0),
    date: sale?.date || 'N/A',
    status: sale?.status || 'unknown',
    recorded_by: sale?.recorded_by || 'N/A'
  };

  const safeCustomer = {
    id: customer?.id || 'N/A',
    name: customer?.name || 'N/A',
    phone_model: customer?.phone_model || 'N/A',
    imei: customer?.imei || 'N/A',
    branch: customer?.branch || 'N/A',
    phone_information: customer?.phone_information || '',
    phone_photo: customer?.phone_photo || null
  };

  const safeProduct = {
    name: product?.name || 'N/A',
    description: product?.description || 'N/A',
    category: product?.category || 'N/A',
    image: product?.image || null
  };

  const safeWarranty = {
    start_date: warranty?.start_date || 'N/A',
    end_date: warranty?.end_date || 'N/A',
    is_valid: warranty?.is_valid || false,
    days_remaining: warranty?.days_remaining || 0,
    status: warranty?.status || 'Unknown'
  };

  const safeContact = {
    shop_name: contact?.shop_name || 'PhoneShop',
    support_email: contact?.support_email || 'support@phoneshop.com',
    support_phone: contact?.support_phone || '+1-234-567-8900'
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
      {/* Header */}
      <div className="bg-white shadow-sm border-b">
        <div className="max-w-4xl mx-auto px-4 py-6">
          <div className="flex items-center justify-between">
            <div>
              <h1 className="text-3xl font-bold text-gray-900">Warranty Information</h1>
              <p className="text-gray-600 mt-1">Customer ID: {safeCustomer.id}</p>
            </div>
            <div className="text-right">
              <div className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${
                safeWarranty.is_valid 
                  ? 'bg-green-100 text-green-800' 
                  : 'bg-red-100 text-red-800'
              }`}>
                {safeWarranty.is_valid ? (
                  <CheckCircle className="h-4 w-4 mr-1" />
                ) : (
                  <XCircle className="h-4 w-4 mr-1" />
                )}
                {safeWarranty.status}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="max-w-4xl mx-auto px-4 py-8">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Main Content */}
          <div className="lg:col-span-2 space-y-6">
            {/* Customer Information */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <User className="h-6 w-6 text-blue-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Customer Information</h2>
              </div>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label className="text-sm font-medium text-gray-500">Customer Name</label>
                  <p className="text-lg font-semibold text-gray-900">{safeCustomer.name}</p>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">Phone Model</label>
                  <p className="text-lg font-semibold text-gray-900">{safeCustomer.phone_model}</p>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">Branch</label>
                  <p className="text-lg font-semibold text-gray-900">{safeCustomer.branch}</p>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">IMEI Number</label>
                  <p className="text-lg font-mono text-gray-900">{safeCustomer.imei}</p>
                </div>
              </div>
              {safeCustomer.phone_information && (
                <div className="mt-4">
                  <label className="text-sm font-medium text-gray-500">Phone Information</label>
                  <p className="text-gray-900 mt-1">{safeCustomer.phone_information}</p>
                </div>
              )}
            </div>

            {/* Product Information */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <Package className="h-6 w-6 text-green-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Product Information</h2>
              </div>
              <div className="flex items-start space-x-4">
                {safeProduct.image && (
                  <img 
                    src={safeProduct.image} 
                    alt={safeProduct.name}
                    className="w-20 h-20 object-cover rounded-lg border"
                  />
                )}
                <div className="flex-1">
                  <h3 className="text-lg font-semibold text-gray-900">{safeProduct.name}</h3>
                  <p className="text-gray-600 mb-2">{safeProduct.description}</p>
                  <div className="flex items-center text-sm text-gray-500">
                    <span className="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                      {safeProduct.category}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            {/* Warranty Information */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <Calendar className="h-6 w-6 text-blue-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Warranty Information</h2>
              </div>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label className="text-sm font-medium text-gray-500">Warranty Start Date</label>
                  <p className="text-lg font-semibold text-gray-900">{safeWarranty.start_date}</p>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">Warranty End Date</label>
                  <p className="text-lg font-semibold text-gray-900">{safeWarranty.end_date}</p>
                </div>
                {safeWarranty.is_valid && safeWarranty.days_remaining > 0 && (
                  <div className="md:col-span-2">
                    <label className="text-sm font-medium text-gray-500">Days Remaining</label>
                    <p className="text-2xl font-bold text-green-600">{safeWarranty.days_remaining} days</p>
                  </div>
                )}
                {!safeWarranty.is_valid && safeWarranty.end_date !== 'N/A' && (
                  <div className="md:col-span-2">
                    <label className="text-sm font-medium text-gray-500">Warranty Status</label>
                    <p className="text-2xl font-bold text-red-600">Expired</p>
                  </div>
                )}
              </div>
            </div>

            {/* Sale Information */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <DollarSign className="h-6 w-6 text-yellow-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Sale Information</h2>
              </div>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label className="text-sm font-medium text-gray-500">Sale Price</label>
                  <p className="text-2xl font-bold text-green-600">${safeSale.price.toFixed(2)}</p>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">Sale Date</label>
                  <p className="text-lg font-semibold text-gray-900">{safeSale.date}</p>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">Sale Status</label>
                  <span className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${
                    safeSale.status === 'sold' ? 'bg-green-100 text-green-800' :
                    safeSale.status === 'returned' ? 'bg-yellow-100 text-yellow-800' :
                    safeSale.status === 'warranty_claim' ? 'bg-blue-100 text-blue-800' :
                    'bg-red-100 text-red-800'
                  }`}>
                    {safeSale.status.replace('_', ' ').toUpperCase()}
                  </span>
                </div>
              </div>
              <div className="mt-4">
                <label className="text-sm font-medium text-gray-500">Recorded By</label>
                <p className="text-gray-900">{safeSale.recorded_by}</p>
              </div>
            </div>
          </div>

          {/* Sidebar */}
          <div className="space-y-6">
            {/* Warranty Status Card */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <Shield className="h-6 w-6 text-purple-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Warranty Status</h2>
              </div>
              
              <div className="text-center mb-4">
                <div className={`inline-flex items-center justify-center w-16 h-16 rounded-full mb-3 ${
                  safeWarranty.is_valid ? 'bg-green-100' : 'bg-red-100'
                }`}>
                  {safeWarranty.is_valid ? (
                    <CheckCircle className="h-8 w-8 text-green-600" />
                  ) : (
                    <XCircle className="h-8 w-8 text-red-600" />
                  )}
                </div>
                <h3 className={`text-lg font-semibold ${
                  safeWarranty.is_valid ? 'text-green-600' : 'text-red-600'
                }`}>
                  {safeWarranty.status}
                </h3>
              </div>

              <div className="space-y-3">
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-500">Start Date</span>
                  <span className="font-medium text-gray-900">{safeWarranty.start_date}</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-500">End Date</span>
                  <span className="font-medium text-gray-900">{safeWarranty.end_date}</span>
                </div>
                {safeWarranty.is_valid && safeWarranty.days_remaining > 0 && (
                  <div className="flex items-center justify-between">
                    <span className="text-sm text-gray-500">Days Remaining</span>
                    <span className="font-medium text-green-600">{safeWarranty.days_remaining} days</span>
                  </div>
                )}
                {!safeWarranty.is_valid && safeWarranty.end_date !== 'N/A' && (
                  <div className="flex items-center justify-between">
                    <span className="text-sm text-gray-500">Status</span>
                    <span className="font-medium text-red-600">Expired</span>
                  </div>
                )}
              </div>
            </div>

            {/* Contact Information */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <Store className="h-6 w-6 text-indigo-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Contact Information</h2>
              </div>
              
              <div className="space-y-3">
                <div className="flex items-center">
                  <Store className="h-4 w-4 text-gray-400 mr-3" />
                  <span className="text-sm text-gray-600">{safeContact.shop_name}</span>
                </div>
                <div className="flex items-center">
                  <Phone className="h-4 w-4 text-gray-400 mr-3" />
                  <a href={`tel:${safeContact.support_phone}`} className="text-sm text-blue-600 hover:underline">
                    {safeContact.support_phone}
                  </a>
                </div>
                <div className="flex items-center">
                  <Mail className="h-4 w-4 text-gray-400 mr-3" />
                  <a href={`mailto:${safeContact.support_email}`} className="text-sm text-blue-600 hover:underline">
                    {safeContact.support_email}
                  </a>
                </div>
              </div>
            </div>

            {/* Customer Phone Photo */}
            {safeCustomer.phone_photo && (
              <div className="bg-white rounded-xl shadow-sm border p-6">
                <h3 className="text-lg font-semibold text-gray-900 mb-4">Phone Photo</h3>
                <img 
                  src={safeCustomer.phone_photo} 
                  alt="Customer Phone"
                  className="w-full h-48 object-cover rounded-lg border"
                />
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default WarrantyPage;
