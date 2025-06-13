import api from "@/api/api";
import FacilityItem from "@/components/FacilityItem";
import HouseUnitGalleryItem from "@/components/HouseTypeGalleryItem";
import { useAuth } from "@/context/AuthContext";
import { HouseUnitResponse } from "@/types/house-unit";
import { capitalizeWords, openWhatsApp } from "@/utils/utils";
import { MaterialIcons } from "@expo/vector-icons";
import { useLocalSearchParams, useRouter } from "expo-router";
import { useEffect, useState } from "react";
import { ActivityIndicator, FlatList, Image, ImageBackground, ScrollView, Text, TouchableOpacity, View } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

export default function HouseUnitDetail() {
  const auth = useAuth();
  const router = useRouter();
  const { id } = useLocalSearchParams();
  const [data, setData] = useState<HouseUnitResponse | null>(null);
  const [loading, setLoading] = useState(false);
  const [onBooking, setOnBooking] = useState(false);
  const [error, setError] = useState(null);

  if (!auth) return null;

  const handleBooking = async () => {
    if (data?.data.status == "tersedia") {
      if (!confirm("Booking unit ini?")) {
        return null;
      }
      try {
        setOnBooking(true);
        const res = await api.post(`/house-units/${id}/bookings`);
        const data = await res.data;
        if (data) {
          router.push({ pathname: "/bookings/[id]", params: { id: data.bookingId } });
        }
      } catch (e: any) {
        setError(e.message);
      } finally {
        setOnBooking(false);
      }
    } else {
      const res = await api.get(`/getBookingId/${id}`);
      const data = await res.data;

      console.log(data);

      router.push({ pathname: "/(protected)/bookings/[id]", params: { id: data.bookingId } });
    }
  };

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const res = await api.get(`house-units/${id}`);
        const data = await res.data;
        setData(data);
      } catch (e: any) {
        setError(e.message);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [id]);

  if (loading || !data) return <ActivityIndicator />;

  if (error) return <Text style={{ color: "red" }}>{error}</Text>;

  return (
    <SafeAreaView style={{ flex: 1, padding: 16, paddingBottom: 100, backgroundColor: "white" }}>
      <ScrollView showsVerticalScrollIndicator={false}>
        <View style={{ gap: 16 }}>
          {/* Heading */}
          <ImageBackground style={{ width: "100%", height: 320, alignItems: "flex-start", padding: 16, borderWidth: 1, borderColor: "lightgray", borderRadius: 24, overflow: "hidden" }} source={data.data.imageUrl} resizeMode="cover">
            <TouchableOpacity style={{ padding: 8, backgroundColor: "white", borderWidth: 1, borderColor: "lightgray", borderRadius: 50 }} onPress={() => router.back()}>
              <MaterialIcons name="arrow-back" size={24} />
            </TouchableOpacity>
          </ImageBackground>

          {/* Deskripsi */}
          <View style={{ flexDirection: "row", alignItems: "flex-start", justifyContent: "space-between" }}>
            <View>
              <Text style={{ fontSize: 18, fontWeight: "bold" }}>{data.data.name}</Text>
              <Text style={{ color: "gray" }}>
                {data.data.block.name}, {data.data.typeName}
              </Text>
            </View>
            <Text style={{ fontSize: 16, fontWeight: "bold", color: "blue" }}>{data.data.price.toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
          </View>

          {/* Ringkasan */}
          <View>
            <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Ringkasan</Text>
            <Text style={{ fontSize: 12, color: "gray" }}>{data.data.summary}</Text>
          </View>

          {/* Kontak marketing */}
          <View>
            <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Kontak marketing</Text>
            <View style={{ flexDirection: "row", alignItems: "center", gap: 8, padding: 8, backgroundColor: "#f1f1f1", borderWidth: 1, borderColor: "lightgray", borderRadius: 50 }}>
              <Image style={{ width: 48, height: 48, borderWidth: 1, borderColor: "lightgray", borderRadius: 50 }} source={data.data.marketing.photoUrl} resizeMode="cover" />
              <View style={{ flex: 1 }}>
                <Text style={{ fontSize: 16, fontWeight: "500" }}>{data.data.marketing.name}</Text>
                <Text style={{ color: "gray" }}>{data.data.marketing.email}</Text>
              </View>
              <TouchableOpacity onPress={() => openWhatsApp(auth.user!, data.data.typeName, data.data.block.name, data.data.name, data.data.marketing.phone!)}>
                <Image style={{ width: 40, height: 40 }} source={require("@/assets/images/whatsapp-logo.png")} resizeMode="contain" />
              </TouchableOpacity>
            </View>
          </View>

          {/* Daftar fasilitas */}
          <View>
            <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Daftar fasilitas rumah</Text>
            <FlatList horizontal contentContainerStyle={{ gap: 12 }} data={data.data.facilities} keyExtractor={(_, index) => index.toString()} renderItem={({ item }) => <FacilityItem item={item} />} />
          </View>

          {/* Galeri unit rumah */}
          <View>
            <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Galeri unit rumah</Text>
            <FlatList horizontal contentContainerStyle={{ gap: 12 }} data={data.data.galleries} keyExtractor={(_, index) => index.toString()} renderItem={({ item }) => <HouseUnitGalleryItem item={item} />} />
          </View>
        </View>
      </ScrollView>

      {/* Tab booking */}
      <View style={{ width: "100%", position: "fixed", left: 0, bottom: 0, flexDirection: "row", alignItems: "center", justifyContent: "space-between", padding: 16, backgroundColor: "white", borderWidth: 1, borderTopLeftRadius: 32, borderTopRightRadius: 32, borderColor: "lightgray" }}>
        <View>
          <Text style={{ marginBottom: 4, fontSize: 18, fontWeight: "bold" }}>Booking Fee</Text>
          <Text style={{ fontSize: 16, fontWeight: "bold", color: "blue" }}>{(500_000).toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
        </View>
        <TouchableOpacity style={{ paddingInline: 16, paddingBlock: 8, backgroundColor: "blue", borderRadius: 24 }} onPress={handleBooking}>
          {data.data.status == "tersedia" ? <Text style={{ fontSize: 16, fontWeight: "500", textAlign: "center", color: "white" }}>{onBooking ? "Memproses booking..." : "Booking sekarang"}</Text> : data.data.status == "dibooking" ? <Text style={{ fontSize: 16, fontWeight: "500", textAlign: "center", color: "white" }}>Lanjutkan pembayaran</Text> : <Text style={{ fontSize: 16, fontWeight: "500", textAlign: "center", color: "white" }}>Lihat detail booking</Text>}
        </TouchableOpacity>
      </View>
    </SafeAreaView>
  );
}
