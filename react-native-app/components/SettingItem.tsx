import type { Setting } from "@/types/index.";
import { MaterialIcons } from "@expo/vector-icons";
import { useRouter } from "expo-router";
import { Text, TouchableOpacity } from "react-native";

export default function SettingItem({ item }: { item: Setting }) {
  const router = useRouter();

  return (
    <TouchableOpacity style={{ flexDirection: "row", alignItems: "center", gap: 8, paddingInline: 16, paddingBlock: 8, backgroundColor: "#f1f1f1", borderWidth: 1, borderColor: "lightgray", borderRadius: 24 }}>
      <MaterialIcons name={item.icon} size={24} />
      <Text style={{ fontSize: 16, fontWeight: "500" }}>{item.name}</Text>
    </TouchableOpacity>
  );
}
