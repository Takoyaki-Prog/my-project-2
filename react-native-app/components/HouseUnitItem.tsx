import type { HouseUnit } from "@/types/index.";
import { useRouter } from "expo-router";
import { Image, Text, TouchableOpacity, View } from "react-native";

export default function HouseUnitItem({ item }: { item: HouseUnit }) {
  const router = useRouter();

  return (
    <TouchableOpacity style={{ flex: 1, gap: 8, padding: 8, backgroundColor: "white", borderWidth: 1, borderColor: "lightgray", borderRadius: 16 }} onPress={() => router.push({ pathname: "/house-units/[id]", params: { id: item.id } })}>
      <Image style={{ width: "100%", height: 160, borderRadius: 8 }} source={item.imageUrl} resizeMode="cover" />
      <View style={{ gap: 4 }}>
        <Text style={{ fontSize: 18, fontWeight: "bold" }}>{item.name}</Text>
        <Text style={{ color: "gray" }}>
          {item.block?.name}, {item.houseType?.name}
        </Text>
        <Text style={{ fontSize: 16, fontWeight: "bold", color: "blue" }}>{item.houseType?.price.toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
      </View>
    </TouchableOpacity>
  );
}
