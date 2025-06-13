import { ListBookingResponse } from "@/types/booking";
import { useRouter } from "expo-router";
import { Image, Text, TouchableOpacity, View } from "react-native";

export default function BookingItem({ item }: { item: ListBookingResponse["data"][number] }) {
  const router = useRouter();

  return (
    <TouchableOpacity style={{ flexDirection: "row", alignItems: "flex-start", gap: 8, padding: 8, backgroundColor: "#f1f1f1", borderWidth: 1, borderColor: "lightgray", borderRadius: 16 }} onPress={() => router.push({ pathname: "/bookings/[id]", params: { id: item.id } })}>
      <Image style={{ width: 100, height: 100, borderWidth: 1, borderColor: "lightgray", borderRadius: 8 }} source={item.imageUrl} resizeMode="cover" />
      <View style={{ flex: 1 }}>
        <Text style={{ fontSize: 18, fontWeight: "bold" }}>{item.unitName}</Text>
        <Text style={{ color: "gray" }}>
          {item.blockName}, {item.typeName}
        </Text>
        <Text style={{ fontSize: 16, fontWeight: "bold", color: "blue" }}>{item.price.toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
      </View>
      <View style={{ paddingInline: 8, paddingBlock: 4, backgroundColor: "blue", borderRadius: 50 }}>
        <Text style={{ color: "white" }}>{item.status}</Text>
      </View>
    </TouchableOpacity>
  );
}
