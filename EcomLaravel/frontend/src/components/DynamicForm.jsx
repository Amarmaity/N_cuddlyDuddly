import Button from "../utils/Button";

function DynamicForm({ fields, formData, errors, onChange, buttonText = "Submit", loading = false }) {
  // Decide number of columns based on field count
  const gridColsClass =
    fields.length > 3
      ? "grid grid-cols-1 md:grid-cols-2 gap-6"
      : "grid grid-cols-1 gap-6";

  return (
    <div>
      {/* Grid */}
      <div className={gridColsClass}>
        {fields.map((field, index) => (
          <div key={index}>
            {/* Label with required indicator */}
            <label className="block text-gray-700 mb-1">
              {field.label}
              {(field.required ?? true) && <span className="text-red-500"> *</span>}:
            </label>

            {/* Render Select */}
            {field.type === "select" ? (
              <select
                name={field.name}
                value={formData[field.name]}
                onChange={onChange}
                className={`w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 ${
                  errors[field.name] ? "border-red-500" : "border-gray-300"
                }`}
              >
                {field.options.map((opt, i) => (
                  <option key={i} value={opt.value}>
                    {opt.label}
                  </option>
                ))}
              </select>
            ) : (
              <input
                type={field.type}
                name={field.name}
                value={formData[field.name]}
                onChange={(e) => {
                  // Restrict mobile field to digits only
                  if (field.name === "mobile") {
                    if (/^\d*$/.test(e.target.value)) {
                      onChange(e);
                    }
                  } else {
                    onChange(e);
                  }
                }}
                placeholder={field.placeholder}
                className={`w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 ${
                  errors[field.name] ? "border-red-500" : "border-gray-300"
                }`}
              />
            )}

            {/* Show validation error */}
            {errors[field.name] && (
              <p className="text-red-500 text-sm mt-1">{errors[field.name]}</p>
            )}
          </div>
        ))}
      </div>

      {/* Button in full width below grid */}
      <div className="pt-6 flex justify-center">
        <Button
          type="submit"
          variant="primary"
          size="md"
          fullWidth
          loading={loading}
          className="max-w-120"
        >
          {buttonText}
        </Button>
      </div>
    </div>
  );
}

export default DynamicForm;