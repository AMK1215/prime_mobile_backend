import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { 
  Gift, 
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
  Store,
  QrCode,
  Copy,
  Download
} from 'lucide-react';
import { apiService } from '../services/api';
import toast from 'react-hot-toast';

const VoucherPage = () => {
  const { voucherCode } = useParams();
  const [voucherData, setVoucherData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchVoucherData = async () => {
      try {
        setLoading(true);
        const response = await apiService.getVoucherByCode(voucherCode);
        setVoucherData(response.data.data);
        setError(null);
      } catch (err) {
        setError(err.response?.data?.message || 'Failed to load voucher information');
      } finally {
        setLoading(false);
      }
    };

    if (voucherCode) {
      fetchVoucherData();
    }
  }, [voucherCode]);

  const copyVoucherCode = () => {
    navigator.clipboard.writeText(safeVoucher.code);
    toast.success('Voucher code copied to clipboard!');
  };

  const downloadQRCode = () => {
    if (safeVoucher?.qr_code_url) {
      const link = document.createElement('a');
      link.href = safeVoucher.qr_code_url;
      link.download = `voucher-${safeVoucher.code}.png`;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      toast.success('QR code downloaded!');
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto"></div>
          <p className="mt-4 text-gray-600">Loading voucher information...</p>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="min-h-screen bg-gradient-to-br from-red-50 to-pink-100 flex items-center justify-center">
        <div className="text-center max-w-md mx-auto p-6">
          <XCircle className="h-16 w-16 text-red-500 mx-auto mb-4" />
          <h1 className="text-2xl font-bold text-gray-900 mb-2">Voucher Not Found</h1>
          <p className="text-gray-600 mb-4">{error}</p>
          <p className="text-sm text-gray-500">
            Please check the voucher code or contact our support team.
          </p>
        </div>
      </div>
    );
  }

  if (!voucherData) {
    return null;
  }

  const { voucher, customer, product, sale } = voucherData;

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

  const safeVoucher = {
    code: voucher?.code || 'N/A',
    type: voucher?.type || 'N/A',
    discount: voucher?.discount || 'N/A',
    valid_from: voucher?.valid_from || 'N/A',
    valid_until: voucher?.valid_until || 'N/A',
    is_valid: voucher?.is_valid || false,
    status: voucher?.status || 'Unknown',
    terms_conditions: voucher?.terms_conditions || '',
    qr_code_url: voucher?.qr_code_url || null,
    voucher_url: voucher?.voucher_url || null
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100">
      {/* Header */}
      <div className="bg-white shadow-sm border-b">
        <div className="max-w-4xl mx-auto px-4 py-6">
          <div className="flex items-center justify-between">
            <div>
              <h1 className="text-3xl font-bold text-gray-900">Customer Voucher</h1>
              <p className="text-gray-600 mt-1">Voucher Code: {safeVoucher.code}</p>
            </div>
            <div className="text-right">
              <div className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${
                safeVoucher.is_valid 
                  ? 'bg-green-100 text-green-800' 
                  : 'bg-red-100 text-red-800'
              }`}>
                {safeVoucher.is_valid ? (
                  <CheckCircle className="h-4 w-4 mr-1" />
                ) : (
                  <XCircle className="h-4 w-4 mr-1" />
                )}
                {safeVoucher.status}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="max-w-4xl mx-auto px-4 py-8">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Main Content */}
          <div className="lg:col-span-2 space-y-6">
            {/* Voucher Information */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <Gift className="h-6 w-6 text-purple-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Voucher Details</h2>
              </div>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label className="text-sm font-medium text-gray-500">Voucher Code</label>
                  <div className="flex items-center space-x-2">
                    <p className="text-lg font-mono font-semibold text-gray-900">{safeVoucher.code}</p>
                    <button
                      onClick={copyVoucherCode}
                      className="p-1 hover:bg-gray-100 rounded"
                      title="Copy voucher code"
                    >
                      <Copy className="h-4 w-4 text-gray-500" />
                    </button>
                  </div>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">Voucher Type</label>
                  <p className="text-lg font-semibold text-gray-900 capitalize">{safeVoucher.type.replace('_', ' ')}</p>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">Discount Value</label>
                  <p className="text-2xl font-bold text-green-600">{safeVoucher.discount}</p>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">Valid Until</label>
                  <p className="text-lg font-semibold text-gray-900">{safeVoucher.valid_until}</p>
                </div>
              </div>
              {safeVoucher.terms_conditions && (
                <div className="mt-4">
                  <label className="text-sm font-medium text-gray-500">Terms & Conditions</label>
                  <p className="text-gray-900 mt-1 text-sm">{safeVoucher.terms_conditions}</p>
                </div>
              )}
            </div>

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
                  <label className="text-sm font-medium text-gray-500">Customer ID</label>
                  <p className="text-lg font-mono text-gray-900">{safeCustomer.id}</p>
                </div>
              </div>
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

            {/* Sale Information */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <DollarSign className="h-6 w-6 text-yellow-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Purchase Information</h2>
              </div>
              <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label className="text-sm font-medium text-gray-500">Purchase Price</label>
                  <p className="text-2xl font-bold text-green-600">${safeSale.price.toFixed(2)}</p>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-500">Purchase Date</label>
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
            </div>
          </div>

          {/* Sidebar */}
          <div className="space-y-6">
            {/* Voucher Status Card */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <Gift className="h-6 w-6 text-purple-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Voucher Status</h2>
              </div>
              
              <div className="text-center mb-4">
                <div className={`inline-flex items-center justify-center w-16 h-16 rounded-full mb-3 ${
                  safeVoucher.is_valid ? 'bg-green-100' : 'bg-red-100'
                }`}>
                  {safeVoucher.is_valid ? (
                    <CheckCircle className="h-8 w-8 text-green-600" />
                  ) : (
                    <XCircle className="h-8 w-8 text-red-600" />
                  )}
                </div>
                <h3 className={`text-lg font-semibold ${
                  safeVoucher.is_valid ? 'text-green-600' : 'text-red-600'
                }`}>
                  {safeVoucher.status}
                </h3>
              </div>

              <div className="space-y-3">
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-500">Valid From</span>
                  <span className="font-medium text-gray-900">{safeVoucher.valid_from}</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-500">Valid Until</span>
                  <span className="font-medium text-gray-900">{safeVoucher.valid_until}</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-500">Discount</span>
                  <span className="font-medium text-green-600">{safeVoucher.discount}</span>
                </div>
              </div>
            </div>

            {/* QR Code */}
            {safeVoucher.qr_code_url && (
              <div className="bg-white rounded-xl shadow-sm border p-6">
                <div className="flex items-center justify-between mb-4">
                  <h3 className="text-lg font-semibold text-gray-900">QR Code</h3>
                  <button
                    onClick={downloadQRCode}
                    className="p-2 hover:bg-gray-100 rounded-lg"
                    title="Download QR code"
                  >
                    <Download className="h-4 w-4 text-gray-500" />
                  </button>
                </div>
                <div className="text-center">
                  <img 
                    src={safeVoucher.qr_code_url} 
                    alt="Voucher QR Code"
                    className="w-32 h-32 mx-auto border rounded-lg"
                  />
                  <p className="text-xs text-gray-500 mt-2">Scan to view voucher details</p>
                </div>
              </div>
            )}

            {/* Contact Information */}
            <div className="bg-white rounded-xl shadow-sm border p-6">
              <div className="flex items-center mb-4">
                <Store className="h-6 w-6 text-indigo-600 mr-2" />
                <h2 className="text-xl font-semibold text-gray-900">Contact Information</h2>
              </div>
              
              <div className="space-y-3">
                <div className="flex items-center">
                  <Store className="h-4 w-4 text-gray-400 mr-3" />
                  <span className="text-sm text-gray-600">PhoneShop</span>
                </div>
                <div className="flex items-center">
                  <Phone className="h-4 w-4 text-gray-400 mr-3" />
                  <a href="tel:+1-234-567-8900" className="text-sm text-blue-600 hover:underline">
                    +1-234-567-8900
                  </a>
                </div>
                <div className="flex items-center">
                  <Mail className="h-4 w-4 text-gray-400 mr-3" />
                  <a href="mailto:support@phoneshop.com" className="text-sm text-blue-600 hover:underline">
                    support@phoneshop.com
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default VoucherPage;
