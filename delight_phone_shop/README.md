# Delight Phone Shop - Client Site

A modern, responsive React application for the Delight Phone Shop client-facing website.

## Features

### 🎨 Modern UI/UX
- **Responsive Design**: Mobile-first approach with seamless desktop experience
- **Modern Components**: Built with React 19 and modern CSS
- **Smooth Animations**: Framer Motion for enhanced user experience
- **Toast Notifications**: React Hot Toast for user feedback

### 🧭 Navigation & Layout
- **Sticky Navbar**: Logo, language switcher (MM/EN), hamburger menu
- **Collapsible Sidebar**: Mobile-friendly navigation with quick links
- **Breadcrumb Navigation**: Easy navigation throughout the site
- **Footer**: Comprehensive footer with contact info and links

### 🖼️ Banner & Content
- **Banner Slider**: Swiper.js powered image carousel with autoplay
- **Banner Text**: Rotating welcome messages with API integration
- **Banner Ads Popup**: One-time popup ads with localStorage persistence
- **Category Section**: Interactive category cards with API integration

### 📱 Product Features
- **Product Grid**: 3-column responsive grid layout
- **Product Cards**: Hover effects, ratings, stock status, quick actions
- **Product Search**: Real-time search with filters and sorting
- **Product Detail**: Comprehensive product information pages

### 🌐 API Integration
- **RESTful APIs**: Integration with Laravel backend
- **Error Handling**: Graceful error handling with fallback content
- **Loading States**: Skeleton loaders and spinners
- **Caching**: Efficient data fetching with custom hooks

### 🔧 Technical Features
- **React Router**: Client-side routing with protected routes
- **Custom Hooks**: Reusable logic for API calls and state management
- **Responsive Images**: Optimized images with lazy loading
- **SEO Ready**: Meta tags and semantic HTML structure

## Tech Stack

- **React 19**: Latest React with concurrent features
- **Vite**: Fast build tool and development server
- **React Router DOM**: Client-side routing
- **Axios**: HTTP client for API requests
- **Swiper**: Touch slider component
- **Lucide React**: Modern icon library
- **React Hot Toast**: Toast notifications
- **Framer Motion**: Animation library

## Project Structure

```
src/
├── components/          # Reusable UI components
│   ├── Navbar.jsx      # Navigation bar with language switcher
│   ├── Sidebar.jsx     # Mobile sidebar navigation
│   ├── BannerSlider.jsx # Hero banner carousel
│   ├── BannerText.jsx  # Welcome text section
│   ├── BannerAds.jsx   # Popup advertisement
│   ├── CategorySection.jsx # Product categories
│   ├── ProductCard.jsx # Product display component
│   └── Footer.jsx      # Site footer
├── pages/              # Page components
│   ├── HomePage.jsx    # Landing page
│   ├── ProductsPage.jsx # Product listing
│   ├── ProductDetailPage.jsx # Product details
│   ├── CategoriesPage.jsx # Category listing
│   ├── AboutPage.jsx   # About us page
│   ├── ContactPage.jsx # Contact form
│   └── NotFoundPage.jsx # 404 page
├── hooks/              # Custom React hooks
│   └── useProducts.js  # Product data management
├── services/           # API services
│   └── api.js          # Axios configuration and endpoints
├── App.jsx             # Main application component
├── main.jsx            # Application entry point
└── index.css           # Global styles and utilities
```

## Getting Started

### Prerequisites
- Node.js 18+ 
- npm or yarn
- Laravel backend running on `http://localhost/api`

### Installation

1. **Install Dependencies**
   ```bash
   npm install
   ```

2. **Development Server**
   ```bash
   npm run dev
   ```

3. **Build for Production**
   ```bash
   npm run build
   ```

4. **Preview Production Build**
   ```bash
   npm run preview
   ```

## API Endpoints

The client connects to the Laravel backend API with the following endpoints:

### Banners & Content
- `GET /api/banner` - Banner slider images
- `GET /api/banner_Text` - Welcome messages
- `GET /api/popup-ads-banner` - Popup advertisements

### Products
- `GET /api/products` - All products with filtering
- `GET /api/products/featured` - Featured products
- `GET /api/products/latest` - Latest products
- `GET /api/products/search` - Search products
- `GET /api/products/category/{id}` - Products by category
- `GET /api/products/{id}` - Single product details

### Categories
- `GET /api/categories` - Product categories
- `GET /api/categories/{id}` - Category details

### Status
- `GET /api/statuses` - Product statuses
- `GET /api/statuses/available` - Available statuses

## Features Overview

### 🏠 Home Page
- Hero banner slider with call-to-action buttons
- Rotating welcome messages
- Featured products section
- Category showcase
- Latest products section
- Newsletter subscription

### 📱 Products Page
- Search and filter functionality
- Grid/list view toggle
- Sorting options (price, date, name)
- Pagination support
- Product cards with hover effects

### 🏷️ Categories Page
- Interactive category cards
- Product count indicators
- Featured category highlights
- Quick navigation links

### 📞 Contact Page
- Contact form with validation
- Store information and hours
- Quick action buttons
- Social media links

### ℹ️ About Page
- Company story and values
- Statistics and achievements
- Team information
- Service highlights

## Responsive Design

The application is fully responsive with breakpoints:
- **Mobile**: < 768px
- **Tablet**: 768px - 1024px  
- **Desktop**: > 1024px

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Development

### Available Scripts

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run preview` - Preview production build
- `npm run lint` - Run ESLint

### Code Style

- ESLint configuration included
- Consistent component structure
- Semantic HTML elements
- Accessible UI components

## Deployment

1. **Build the application**
   ```bash
   npm run build
   ```

2. **Deploy the `dist` folder** to your web server

3. **Configure API base URL** in `src/services/api.js` for production

## Contributing

1. Follow the existing code style
2. Add proper error handling
3. Include loading states
4. Test responsive design
5. Update documentation

## License

© 2025 Delight Phone Shop. All rights reserved.