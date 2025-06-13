import SettingItem from "@/components/SettingItem";
import { SETTINGS } from "@/constants";
import { useAuth } from "@/context/AuthContext";
import { useState } from "react";
import { FlatList, Text, TouchableOpacity } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

export default function Setting() {
  const auth = useAuth();
  const [loading, setLoading] = useState(false);

  if (!auth) return null;

  const handleLogout = async () => {
    if (!confirm("Keluar sesi saat ini?")) return null;

    setLoading(true);
    await auth.logout();
    setLoading(false);
  };

  return (
    <SafeAreaView style={{ flex: 1, padding: 16, backgroundColor: "white" }}>
      <FlatList
        contentContainerStyle={{ gap: 12 }}
        data={SETTINGS}
        keyExtractor={(_, index) => index.toString()}
        renderItem={({ item }) => <SettingItem item={item} />}
        ListFooterComponent={() => (
          <TouchableOpacity style={{ padding: 12, backgroundColor: "red", borderRadius: 24 }} onPress={handleLogout} disabled={loading}>
            <Text style={{ fontSize: 16, fontWeight: "600", textAlign: "center", color: "white" }}>{loading ? "Sedang mengeluarkan Anda..." : "Keluar"}</Text>
          </TouchableOpacity>
        )}
      />
    </SafeAreaView>
  );
}
