import { useState, useEffect } from "react";
import { fetchApi } from "../lib/api";
import { getFallbackTeam } from "../data/fallbackData";

export const useTeam = () => {
  const [team, setTeam] = useState(() => getFallbackTeam());
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchTeam = async () => {
      try {
        setLoading(true);
        const data = await fetchApi("/team");
        if (Array.isArray(data) && data.length > 0) {
          setTeam(data);
        } else {
          setTeam(getFallbackTeam());
        }
        setError(null);
      } catch (err) {
        console.warn("API unavailable, using offline fallback team:", err.message);
        setTeam(getFallbackTeam());
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchTeam();
  }, []);

  return { team, loading, error };
};
