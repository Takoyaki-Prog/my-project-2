import type { HouseType } from "@/types/index.";
import { useRouter } from "expo-router";
import { ImageBackground, Text, TouchableOpacity } from "react-native";

export default function HouseTypeItem({ item }: { item: HouseType }) {
  const router = useRouter();

  return (
    <TouchableOpacity style={{ width: 250, height: 280, borderWidth: 1, borderColor: "lightgray", borderRadius: 16, overflow: "hidden" }} onPress={() => router.push({ pathname: "/house-types/[id]", params: { id: item.id } })}>
      <ImageBackground style={{ width: "100%", height: "100%", justifyContent: "flex-end", padding: 16 }} source={item.imageUrl} resizeMode="cover">
        <Text style={{ fontSize: 20, fontWeight: "bold", color: "white" }}>{item.name}</Text>
        <Text style={{ fontSize: 18, fontWeight: "bold", color: "blue" }}>{item.price.toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
      </ImageBackground>
    </TouchableOpacity>
  );
}
