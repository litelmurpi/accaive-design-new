import { useState } from "react";
import { API_BASE } from "../lib/api";

export const useContact = () => {
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState(null);

  const submitContact = async (formData) => {
    setLoading(true);
    setError(null);
    setSuccess(false);

    try {
      const response = await fetch(`${API_BASE}/contact`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json();

      if (!response.ok) {
        // If Laravel validation fails, it sends 422 with { errors: {...} }
        throw new Error(
          data.message || "Something went wrong while submitting.",
        );
      }

      setSuccess(true);
      return data;
    } catch (err) {
      setError(err.message);
      throw err;
    } finally {
      setLoading(false);
    }
  };

  return { submitContact, loading, success, error };
};
