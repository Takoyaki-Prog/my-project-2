import api from "@/api/api";
import { PAYMENTS } from "@/constants";
import { useAuth } from "@/context/AuthContext";
import { MaterialIcons } from "@expo/vector-icons";
import { useLocalSearchParams, useRouter } from "expo-router";
import { useEffect, useState } from "react";
import { ActivityIndicator, ImageBackground, ScrollView, Text, TouchableOpacity, View } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

interface PaymentDetail {
  paymentId: number;
  unitImageUrl: any;
  unitName: string;
  hargaUnit: number;
  typeName: string;
  blockName: string;
  tangggalBooking: Date;
  biayaBooking: number;
  idTransaksi: number;
  metodePembelian: string;
}

export default function PaymentDetail() {
  const auth = useAuth();
  const router = useRouter();
  const { id } = useLocalSearchParams();
  const [data, setData] = useState<PaymentDetail | null>(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  if (!auth) return null;

  const handleUploadDocument = () => router.push({ pathname: "/documents/[id]", params: { id: 1 } });

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);

        const res = await api.get(`/payments/${id}`);
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

  if (!data || loading) return <ActivityIndicator />;
  if (error) return <Text style={{ color: "red" }}>{error}</Text>;

  return (
    <SafeAreaView style={{ flex: 1, padding: 16, paddingBottom: 100, backgroundColor: "white" }}>
      <ScrollView showsVerticalScrollIndicator={false}>
        <View style={{ gap: 16 }}>
          {/* Heading */}
          <ImageBackground style={{ width: "100%", height: 320, alignItems: "flex-start", padding: 16, borderWidth: 1, borderColor: "lightgray", borderRadius: 24, overflow: "hidden" }} source={{ uri: data.unitImageUrl }} resizeMode="cover">
            {/* <TouchableOpacity style={{ padding: 8, backgroundColor: "white", borderWidth: 1, borderColor: "lightgray", borderRadius: 50 }} onPress={() => router.back()}>
              <MaterialIcons name="arrow-back" size={24} />
            </TouchableOpacity> */}
          </ImageBackground>

          {/* Deskripsi */}
          <View style={{ flexDirection: "row", alignItems: "flex-start", justifyContent: "space-between" }}>
            <View>
              <Text style={{ fontSize: 18, fontWeight: "bold" }}>{data.unitName}</Text>
              <Text style={{ color: "gray" }}>
                {data.blockName}, {data.typeName}
              </Text>
            </View>
            <Text style={{ fontSize: 16, fontWeight: "bold", color: "blue" }}>{data.hargaUnit.toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
          </View>

          {/* Ringkasan booking */}
          <View>
            <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Ringkasan booking</Text>
            <View style={{ flexDirection: "row", alignItems: "center", justifyContent: "space-between", paddingBottom: 8, borderBottomWidth: 1, borderColor: "lightgray" }}>
              <Text>Booking fee</Text>
              <Text>{data.biayaBooking.toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
            </View>
            <View style={{ flexDirection: "row", alignItems: "center", justifyContent: "space-between", paddingBottom: 8, borderBottomWidth: 1, borderColor: "lightgray" }}>
              <Text>Tanggal Booking</Text>
              <Text>
                {new Date(data.tangggalBooking).toLocaleDateString("id-ID", {
                  dateStyle: "full",
                })}
              </Text>
            </View>
          </View>

          {/* Ringkasan Transaksi */}
          <View>
            <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Ringkasan booking</Text>
            <View style={{ flexDirection: "row", alignItems: "center", justifyContent: "space-between", paddingBottom: 8, borderBottomWidth: 1, borderColor: "lightgray" }}>
              <Text>Id transaksi</Text>
              <Text style={{ fontWeight: "500", color: "blue" }}>{data.idTransaksi}</Text>
            </View>
            <View style={{ flexDirection: "row", alignItems: "center", justifyContent: "space-between", paddingBottom: 8, borderBottomWidth: 1, borderColor: "lightgray" }}>
              <Text>Nama</Text>
              <Text>{auth.user?.name}</Text>
            </View>
            <View style={{ flexDirection: "row", alignItems: "center", justifyContent: "space-between", paddingBottom: 8, borderBottomWidth: 1, borderColor: "lightgray" }}>
              <Text>Email</Text>
              <Text>{auth.user?.email}</Text>
            </View>
            <View style={{ flexDirection: "row", alignItems: "center", justifyContent: "space-between", paddingBottom: 8, borderBottomWidth: 1, borderColor: "lightgray" }}>
              <Text>Metode Pembelian</Text>
              <Text>{data.metodePembelian}</Text>
            </View>
          </View>
        </View>
      </ScrollView>

      {/* Tab unggah dokumen dan ke beranda */}
      <View style={{ width: "100%", position: "fixed", left: 0, bottom: 0, gap: 8, padding: 16, backgroundColor: "white", borderWidth: 1, borderTopLeftRadius: 32, borderTopRightRadius: 32, borderColor: "lightgray" }}>
        <TouchableOpacity style={{ paddingInline: 16, paddingBlock: 8, backgroundColor: "blue", borderRadius: 24 }} onPress={handleUploadDocument}>
          <Text style={{ fontSize: 16, fontWeight: "500", textAlign: "center", color: "white" }}>Unggah Dokumen</Text>
        </TouchableOpacity>
        <TouchableOpacity style={{ paddingInline: 16, paddingBlock: 8, backgroundColor: "#f1f1f1", borderWidth: 1, borderColor: "lightgray", borderRadius: 24 }} onPress={() => router.push("/")}>
          <Text style={{ fontSize: 16, fontWeight: "500", textAlign: "center" }}>Ke Beranda</Text>
        </TouchableOpacity>
      </View>
    </SafeAreaView>
  );
}
