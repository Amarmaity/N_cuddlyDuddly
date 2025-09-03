import React from "react";

const Footer = () => {
  return (
    <footer className="bg-gray-900 text-gray-300 py-8 mt-12">
      <div className="container mx-auto px-6 md:px-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          {/* Logo + About */}
          <div>
            <h2 className="text-2xl font-bold text-white mb-3">MyShop</h2>
            <p className="text-sm text-gray-400">
              Your one-stop shop for all things you love. Quality products,
              great prices, and fast delivery.
            </p>
          </div>

          {/* Quick Links */}
          <div>
            <h3 className="text-lg font-semibold text-white mb-3">
              Quick Links
            </h3>
            <ul className="space-y-2">
              <li>
                <a href="/" className="hover:text-blue-400">
                  Home
                </a>
              </li>
              <li>
                <a href="/shop" className="hover:text-blue-400">
                  Shop
                </a>
              </li>
              <li>
                <a href="/about" className="hover:text-blue-400">
                  About
                </a>
              </li>
              <li>
                <a href="/contact" className="hover:text-blue-400">
                  Contact
                </a>
              </li>
            </ul>
          </div>

          {/* Customer Support */}
          <div>
            <h3 className="text-lg font-semibold text-white mb-3">
              Customer Support
            </h3>
            <ul className="space-y-2">
              <li>
                <a href="/faq" className="hover:text-blue-400">
                  FAQs
                </a>
              </li>
              <li>
                <a href="/returns" className="hover:text-blue-400">
                  Returns
                </a>
              </li>
              <li>
                <a href="/shipping" className="hover:text-blue-400">
                  Shipping
                </a>
              </li>
              <li>
                <a href="/privacy" className="hover:text-blue-400">
                  Privacy Policy
                </a>
              </li>
            </ul>
          </div>

          {/* Newsletter */}
          <div>
            <h3 className="text-lg font-semibold text-white mb-3">
              Stay Updated
            </h3>
            <p className="text-sm text-gray-400 mb-3">
              Subscribe to our newsletter for deals & updates.
            </p>
            <form className="flex">
              <input
                type="email"
                placeholder="Enter your email"
                className="w-full px-3 py-2 rounded-l-md focus:outline-none text-gray-800"
              />
              <button
                type="submit"
                className="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-r-md"
              >
                Subscribe
              </button>
            </form>
          </div>
        </div>

        {/* Bottom */}
        <div className="border-t border-gray-700 mt-8 pt-4 text-center text-sm text-gray-500">
          © {new Date().getFullYear()} MyShop. All rights reserved.
        </div>
      </div>
    </footer>
  );
};

export default Footer;