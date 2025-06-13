import type { Facility } from "@/types/index.";
import { Image, Text, TouchableOpacity } from "react-native";

export default function FacilityItem({ item }: { item: Facility }) {
  return (
    <TouchableOpacity style={{ width: 78, height: "auto", gap: 4, padding: 8, backgroundColor: "white", borderWidth: 1, borderColor: "lightgray", borderRadius: 16 }}>
      <Image style={{ width: "100%", height: 60, borderWidth: 1, borderColor: "lightgray", borderRadius: 8 }} source={item.imageUrl} resizeMode="cover" />
      <Text>{item.name}</Text>
    </TouchableOpacity>
  );
}
