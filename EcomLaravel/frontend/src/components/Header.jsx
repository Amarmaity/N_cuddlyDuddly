import { useState } from "react";
import { ShoppingCart, User, Search, LogIn, UserPlus } from "lucide-react";
import { NavLink, Link } from "react-router-dom";
import { IoMdLogOut } from "react-icons/io";

const Header = () => {
  const [showModal, setShowModal] = useState(false);

  const handleLogout = async () => {
    try {
      const refresh = localStorage.getItem("refresh"); // stored at login
      await fetch("http://127.0.0.1:8000/api/logout/", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("access")}`,
        },
        body: JSON.stringify({ refresh }),
      });

      // clear local storage
      localStorage.removeItem("access");
      localStorage.removeItem("refresh");
      localStorage.removeItem("user_type");

      // redirect
      window.location.href = "/login";
    } catch (error) {
      console.error("Logout failed", error);
    }
  };

  const handleConfirm = () => {
    setShowModal(false);
    handleLogout();
  };

  return (
    <header className="bg-white shadow-md sticky top-0 z-50">
      <div className="container mx-auto flex items-center justify-between px-6 py-4">
        {/* Logo */}
        <Link to="/" className="text-2xl font-bold text-blue-600">
          MyShop
        </Link>

        {/* Navbar links */}
        <nav className="hidden md:flex space-x-8 text-gray-700 font-medium">
          <NavLink to="/" className="hover:text-blue-600">
            Home
          </NavLink>
          <NavLink to="/about" className="hover:text-blue-600">
            About
          </NavLink>
          <NavLink to="/shop" className="hover:text-blue-600">
            Shop
          </NavLink>
          <NavLink to="/contact" className="hover:text-blue-600">
            Contact
          </NavLink>
        </nav>

        {/* Right side icons */}
        <div className="flex items-center space-x-6 relative">
          {/* Search */}
          <div className="relative hidden sm:block">
            <input
              type="text"
              placeholder="Search Products..."
              className="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <Search className="absolute left-3 top-2.5 h-5 w-5 text-gray-500" />
          </div>

          {/* User Dropdown */}
          <div className="relative group">
            <button className="text-gray-700 hover:text-blue-600">
              <User className="h-6 w-6" />
            </button>

            {/* Dropdown on hover */}
            <div className="absolute right-0 w-40 bg-white shadow-lg rounded-lg border opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-opacity duration-200 z-50">
              <Link
                to="/login"
                className="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700"
              >
                <LogIn className="h-5 w-5 mr-2 text-blue-600" />
                Sign In
              </Link>
              <Link
                to="/register"
                className="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700"
              >
                <UserPlus className="h-5 w-5 mr-2 text-green-600" />
                Register
              </Link>
            </div>
          </div>

          {/* Cart */}
          <Link
            to="/cart"
            className="relative text-gray-700 hover:text-blue-600"
          >
            <ShoppingCart className="h-6 w-6" />
            <span className="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
              1
            </span>
          </Link>

          {/* Logout with confirmation */}
          <button
            onClick={() => setShowModal(true)}
            className="text-gray-700 hover:text-red-600"
          >
            <IoMdLogOut className="h-6 w-6" />
          </button>
        </div>
      </div>

      {/* Logout confirmation modal */}
      {showModal && (
        <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
          <div className="bg-white p-6 rounded-2xl shadow-lg max-w-sm w-full">
            <h2 className="text-lg font-semibold text-gray-800">
              Are you sure you want to logout?
            </h2>

            <div className="mt-4 flex justify-end gap-3">
              <button
                className="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400"
                onClick={() => setShowModal(false)}
              >
                Cancel
              </button>
              <button
                className="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                onClick={handleConfirm}
              >
                Logout
              </button>
            </div>
          </div>
        </div>
      )}
    </header>
  );
};

export default Header;