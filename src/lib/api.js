export const API_BASE =
  import.meta.env.VITE_API_URL || "http://127.0.0.1:8000/api";

const cache = new Map();
const activeRequests = new Map();
const CACHE_TTL = 5 * 60 * 1000; // 5 minutes

export function invalidateCache(endpoint) {
  if (endpoint) {
    cache.delete(endpoint);
  } else {
    cache.clear();
  }
}

/**
 * Fetch wrapper to handle basic JSON responses with caching and deduplication
 */
export async function fetchApi(endpoint, options = {}) {
  const isGet = !options.method || options.method.toUpperCase() === 'GET';
  
  if (isGet) {
    const cached = cache.get(endpoint);
    if (cached && Date.now() - cached.timestamp < CACHE_TTL) {
      return cached.data;
    }

    if (activeRequests.has(endpoint)) {
      return activeRequests.get(endpoint);
    }
  }

  const fetchPromise = (async () => {
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

      const json = await response.json();
      const data = json.data;

      if (isGet) {
        cache.set(endpoint, {
          data,
          timestamp: Date.now()
        });
      }

      return data;
    } catch (error) {
      console.error("API Fetch Failed:", error);
      throw error;
    } finally {
      if (isGet) {
        activeRequests.delete(endpoint);
      }
    }
  })();

  if (isGet) {
    activeRequests.set(endpoint, fetchPromise);
  }

  return fetchPromise;
}
