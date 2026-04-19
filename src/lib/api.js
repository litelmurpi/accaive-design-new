export const API_BASE =
  import.meta.env.VITE_API_URL || "http://127.0.0.1:8001/api";

/**
 * Fetch wrapper to handle basic JSON responses
 */
export async function fetchApi(endpoint, options = {}) {
  try {
    const response = await fetch(`${API_BASE}${endpoint}`, {
      headers: {
        Accept: "application/json",
        ...options.headers,
      },
      ...options,
    });

    if (!response.ok) {
      throw new Error(`API Error: ${response.status} ${response.statusText}`);
    }

    const data = await response.json();
    return data.data; // Since our endpoints return { data: [...] }
  } catch (error) {
    console.error("API Fetch Failed:", error);
    throw error;
  }
}
