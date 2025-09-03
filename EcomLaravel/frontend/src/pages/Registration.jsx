import React, { useState } from "react";
import Swal from "sweetalert2";
import { Link } from "react-router-dom";
import DynamicForm from "../components/DynamicForm";
import Button from "../utils/Button";

function Registration() {
  // ✅ Define fields inside the component
  const registrationFields = [
    {
      name: "name",
      label: "Full Name",
      type: "text",
      placeholder: "Enter your full name",
    },
    {
      name: "email",
      label: "Email",
      type: "email",
      placeholder: "Enter your email",
    },
    {
      name: "user_type",
      label: "User Type",
      type: "select",
      options: [
        { value: "", label: "Select user type" },
        { value: "admin", label: "Admin" },
        { value: "customer", label: "Customer" },
        { value: "vendor", label: "Vendor" },
      ],
    },
    {
      name: "phone",
      label: "Phone",
      type: "text",
      placeholder: "Enter 10-digit phone number",
    },
    {
      name: "password",
      label: "Password",
      type: "password",
      placeholder: "Enter password",
    },
    {
      name: "confirmPassword",
      label: "Confirm Password",
      type: "password",
      placeholder: "Re-enter password",
    },
  ];

  // ✅ initialize state based on fields
  const [formData, setFormData] = useState(
    registrationFields.reduce((acc, field) => {
      acc[field.name] = "";
      return acc;
    }, {})
  );

  const [errors, setErrors] = useState({});

  // ✅ handle change
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  // ✅ validation
  const validate = () => {
    const newErrors = {};

    // Full Name: required and only alphabets
    if (!formData.name) {
      newErrors.name = "Name field is required.";
    } else if (/[^a-zA-Z\s]/.test(formData.name)) {
      newErrors.name = "Name cannot contain numbers or special characters.";
    }

    // Email validation
    if (!formData.email) {
      newErrors.email = "Email is required";
    } else if (!/\S+@\S+\.\S+/.test(formData.email)) {
      newErrors.email = "Email is invalid";
    }

    // Phone validation
    if (!formData.phone) {
      newErrors.phone = "Phone number is required";
    } else if (!/^\d{10}$/.test(formData.phone)) {
      newErrors.phone = "Phone number must be 10 digits";
    }

    // Password validation
    if (!formData.password) {
      newErrors.password = "Password is required";
    } else if (formData.password.length < 6) {
      newErrors.password = "Password must be at least 6 characters long";
    }

    // Confirm Password validation
    if (formData.password !== formData.confirmPassword) {
      newErrors.confirmPassword = "Passwords do not match";
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  // ✅ submit
  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!validate()) return;

    const payload = {
      ...formData,
      confirm_password: formData.confirmPassword, // backend expects confirm_password
    };

    try {
      const response = await fetch("http://localhost:8000/api/register/", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
      });

      const data = await response.json();

      if (response.ok) {
        Swal.fire("Success", "User registered successfully!", "success");
        setFormData(
          registrationFields.reduce((acc, field) => {
            acc[field.name] = "";
            return acc;
          }, {})
        );
        setErrors({});
      } else {
        setErrors(data);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-100 p-4">
      <div className="w-220 bg-white rounded-lg shadow-md p-6">
        <h2 className="text-2xl font-bold mb-6 text-center text-gray-800">
          Registration Form
        </h2>

        <form onSubmit={handleSubmit} className="space-y-4">
          <DynamicForm
            fields={registrationFields} // ✅ updated fields
            formData={formData}
            errors={errors}
            onChange={handleChange}
            buttonText="Register"
          />
        </form>
        <p className="text-sm text-gray-600 mt-4 text-center">
          Already have an account?{" "}
          <Link to="/login" className="text-blue-500 hover:underline">
            Login
          </Link>
        </p>
      </div>
    </div>
  );
}

export default Registration;
