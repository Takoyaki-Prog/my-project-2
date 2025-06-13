import api, { setAuthToken } from "@/api/api";
import type { User } from "@/types/auth";
import { useRouter } from "expo-router";
import { createContext, PropsWithChildren, useContext, useEffect, useState } from "react";

interface AuthState {
  user: User | null;
  token: string | null;
  register: (name: string, email: string, password: string) => Promise<any>;
  login: (email: string, password: string) => Promise<any>;
  logout: () => Promise<any>;
}

export const AuthContext = createContext<AuthState | null>(null);

export const AuthProvider = ({ children }: PropsWithChildren) => {
  const router = useRouter();
  const [user, setUser] = useState<User | null>(null);
  const [token, setToken] = useState(null);

  const register = async (name: string, email: string, password: string) => {
    try {
      const res = await api.post("auth/register", {
        name: name,
        email: email,
        password: password,
      });

      if (res) {
        const data = await res.data;
        setToken(data.token);
        setAuthToken(data.token);
        const user = data.user;
        setUser({
          id: user.id,
          photoUrl: user.photo,
          name: user.name,
          email: user.email,
          role: user.role,
        });

        const json = JSON.stringify({ token: data.token, user: user });
        localStorage.setItem("auth-storage", json);

        router.replace("/");
        return { success: true };
      }
    } catch (e: any) {
      return { success: false, errors: e.response?.data?.errors || {} };
    }
  };

  const login = async (email: string, password: string) => {
    try {
      const res = await api.post("auth/login", {
        email: email,
        password: password,
      });

      if (res) {
        const data = await res.data;
        setToken(data.token);
        setAuthToken(data.token);
        const user = data.user;
        setUser({
          id: user.id,
          photoUrl: user.photo,
          name: user.name,
          email: user.email,
          role: user.role,
        });

        const json = JSON.stringify({ token: data.token, user: user });
        localStorage.setItem("auth-storage", json);

        router.replace("/");
        return { success: true };
      }
    } catch (e: any) {
      return { success: false, errors: e.response?.data?.errors || {} };
    }
  };

  const logout = async () => {
    try {
      const res = await api.post("auth/logout");

      if (res) {
        setToken(null);
        setAuthToken(null);
        setUser(null);

        localStorage.removeItem("auto-storage");

        router.replace("/(auth)/login");
        return { success: true };
      }
    } catch (e: any) {
      return { success: false, errors: e.response?.data?.errors || {} };
    }
  };

  useEffect(() => {
    const json = localStorage.getItem("auth-storage");

    if (json) {
      const { token, user } = JSON.parse(json!);

      setToken(token);
      setAuthToken(token);
      setUser({
        id: user.id,
        photoUrl: user.photo,
        name: user.name,
        email: user.email,
        role: user.role,
      });
    }
  }, []);

  return <AuthContext.Provider value={{ user, token, register, login, logout }}>{children}</AuthContext.Provider>;
};

export const useAuth = () => useContext(AuthContext);
