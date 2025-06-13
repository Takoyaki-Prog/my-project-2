import api from "@/api/api";
import FacilityItem from "@/components/FacilityItem";
import HouseTypeGaleryItem from "@/components/HouseTypeGaleryItem";
import HouseUnitItem from "@/components/HouseUnitItem";
import type { HouseTypeResponse } from "@/types/house-type";
import { MaterialIcons } from "@expo/vector-icons";
import { useLocalSearchParams, useRouter } from "expo-router";
import { useEffect, useState } from "react";
import { ActivityIndicator, FlatList, ImageBackground, Text, TouchableOpacity, View } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

export default function HouseTypeDetail() {
  const router = useRouter();
  const { id } = useLocalSearchParams();
  const [data, setData] = useState<HouseTypeResponse | null>(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fecthData = async () => {
      try {
        setLoading(true);
        const res = await api.get(`/house-types/${id}`);
        const data = await res.data;
        setData(data);
      } catch (e: any) {
        setError(e.message);
      } finally {
        setLoading(false);
      }
    };
    fecthData();
  }, [id]);

  if (loading || !data) return <ActivityIndicator />;

  if (error) return <Text style={{ color: "red" }}>{error}</Text>;

  return (
    <SafeAreaView style={{ flex: 1, padding: 16, backgroundColor: "white" }}>
      <FlatList
        ListHeaderComponent={() => (
          <View style={{ gap: 16 }}>
            {/* Heading */}
            <ImageBackground style={{ width: "100%", height: 320, alignItems: "flex-start", padding: 16, borderWidth: 1, borderColor: "lightgray", borderRadius: 24, overflow: "hidden" }} source={data.data.imageUrl} resizeMode="cover">
              <TouchableOpacity style={{ padding: 8, backgroundColor: "white", borderWidth: 1, borderColor: "lightgray", borderRadius: 50 }} onPress={() => router.back()}>
                <MaterialIcons name="arrow-back" size={24} />
              </TouchableOpacity>
            </ImageBackground>

            {/* Deskripsi */}
            <View style={{ flexDirection: "row", alignItems: "center", justifyContent: "space-between" }}>
              <Text style={{ fontSize: 18, fontWeight: "bold" }}>{data.data.name}</Text>
              <Text style={{ fontSize: 16, fontWeight: "bold", color: "blue" }}>{data.data.price.toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
            </View>

            {/* Ringkasan */}
            <View>
              <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Ringkasan</Text>
              <Text style={{ fontSize: 12, color: "gray" }}>{data.data.summary}</Text>
            </View>

            {/* Daftar fasilitas */}
            <View>
              <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Daftar fasilitas rumah</Text>
              <FlatList horizontal contentContainerStyle={{ gap: 12 }} data={data.data.facilities} keyExtractor={(_, index) => index.toString()} renderItem={({ item }) => <FacilityItem item={item} />} />
            </View>

            {/* Galeri tipe rumah */}
            <View>
              <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Galeri tipe rumah</Text>
              <FlatList horizontal contentContainerStyle={{ gap: 12 }} data={data.data.galleries} keyExtractor={(_, index) => index.toString()} renderItem={({ item }) => <HouseTypeGaleryItem item={item} />} />
            </View>

            {/* Daftar unit rumah terkait */}
            <Text style={{ marginBottom: -4, fontSize: 16, fontWeight: "500" }}>Daftar unit rumah terkait</Text>
          </View>
        )}
        showsVerticalScrollIndicator={false}
        numColumns={2}
        contentContainerStyle={{ gap: 12 }}
        columnWrapperStyle={{ gap: 12 }}
        data={data.data.units}
        keyExtractor={(_, index) => index.toString()}
        renderItem={({ item }) => <HouseUnitItem item={item} />}
      />
    </SafeAreaView>
  );
}
