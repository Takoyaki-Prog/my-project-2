import type { User } from "@/types/auth";
import { Linking } from "react-native";

export const openWhatsApp = (user: User, type: string, block: string, unit: string, phone: string) => {
  const message = `Halo, saya ${user.name}. Saya tertarik dengan rumah tipe ${type} di ${block}, Unit ${unit}. Mohon informasinya terkait ketersediaan, harga, dan proses pemesanannya. Terima kasih.`;
  const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
  Linking.openURL(url);
};

export const capitalizeWords = (text: string): string => {
  if (!text) return "";
  return text
    .toLowerCase()
    .split(" ")
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(" ");
};
