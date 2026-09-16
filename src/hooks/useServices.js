import { useState, useEffect } from "react";
import { fetchApi } from "../lib/api";
import { getFallbackServices } from "../data/fallbackData";

export const useServices = () => {
  const [services, setServices] = useState(() => getFallbackServices());
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchServices = async () => {
      try {
        setLoading(true);
        const data = await fetchApi("/services");
        if (Array.isArray(data) && data.length > 0) {
          setServices(data);
        } else {
          setServices(getFallbackServices());
        }
        setError(null);
      } catch (err) {
        console.warn("API unavailable, using offline fallback services:", err.message);
        setServices(getFallbackServices());
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchServices();
  }, []);

  return { services, loading, error };
};
