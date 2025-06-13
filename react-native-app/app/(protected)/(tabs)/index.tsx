import api from "@/api/api";
import BlockItem from "@/components/BlockItem";
import HouseTypeItem from "@/components/HouseTypeItem";
import HouseUnitItem from "@/components/HouseUnitItem";
import { useAuth } from "@/context/AuthContext";
import { HomeResponse } from "@/types/home";
import { MaterialIcons } from "@expo/vector-icons";
import { useEffect, useState } from "react";
import { ActivityIndicator, FlatList, Image, Text, View } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

export default function Home() {
  const auth = useAuth();
  const [data, setData] = useState<HomeResponse | null>(null);
  const [selectedBlock, setSelectedBlock] = useState(1);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  if (!auth) return null;

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const res = await api.get("/");
        const data = await res.data;
        setData(data);
      } catch (e: any) {
        setError(e.message);
        console.error(e.message);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, []);

  if (loading || !data) return <ActivityIndicator />;

  if (error) return <Text>{error}</Text>;

  return (
    <SafeAreaView style={{ flex: 1, padding: 16, backgroundColor: "white" }}>
      <FlatList
        ListHeaderComponent={() => (
          <View style={{ gap: 16 }}>
            {/* Heading */}
            <View style={{ flexDirection: "row", alignItems: "center", gap: 8 }}>
              <Image style={{ width: 48, height: 48, borderRadius: 50 }} source={{ uri: auth.user?.photoUrl }} resizeMode="cover" />
              <View style={{ flex: 1 }}>
                <Text style={{ fontSize: 14, color: "gray" }}>Selamat datang</Text>
                <Text style={{ fontSize: 16, fontWeight: "500" }}>{auth.user?.name}</Text>
              </View>
              <MaterialIcons name="notifications" size={24} />
            </View>

            {/* Daftar tipe rumah */}
            <View>
              <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Daftar tipe rumah</Text>
              <FlatList horizontal contentContainerStyle={{ gap: 12 }} data={data.data.houseTypes} keyExtractor={(_, index) => index.toString()} renderItem={({ item }) => <HouseTypeItem item={item} />} />
            </View>

            {/* Daftar blok */}
            <View>
              <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Daftar tipe rumah</Text>
              <FlatList horizontal contentContainerStyle={{ gap: 12 }} data={data.data.blockHouseUnits} keyExtractor={(_, index) => index.toString()} renderItem={({ item }) => <BlockItem item={item} selectedBlock={selectedBlock} setSelectedBlock={setSelectedBlock} />} />
            </View>

            {/* Daftar unit rumah */}
            <Text style={{ marginBottom: -4, fontSize: 16, fontWeight: "500" }}>Daftar unit rumah</Text>
          </View>
        )}
        showsVerticalScrollIndicator={false}
        numColumns={2}
        contentContainerStyle={{ gap: 12 }}
        columnWrapperStyle={{ gap: 12 }}
        data={data.data.houseUnits}
        keyExtractor={(_, index) => index.toString()}
        renderItem={({ item }) => <HouseUnitItem item={item} />}
      />
    </SafeAreaView>
  );
}
