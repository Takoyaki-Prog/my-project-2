import type { HouseTypeGalery } from "@/types/index.";
import { Image, Text, TouchableOpacity, View } from "react-native";

export default function HouseTypeGaleryItem({ item }: { item: HouseTypeGalery }) {
  return (
    <TouchableOpacity style={{ width: 120, height: "auto", gap: 4, padding: 8, backgroundColor: "white", borderWidth: 1, borderColor: "lightgray", borderRadius: 16 }}>
      <Image style={{ width: "100%", height: 104, borderWidth: 1, borderColor: "lightgray", borderRadius: 8 }} source={item.imageUrl} resizeMode="cover" />
      <View>
        <Text>{item.name}</Text>
      </View>
    </TouchableOpacity>
  );
}
