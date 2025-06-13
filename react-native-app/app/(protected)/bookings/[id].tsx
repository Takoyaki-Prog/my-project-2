import api from "@/api/api";
import { useAuth } from "@/context/AuthContext";
import { BookingResponse } from "@/types/booking";
import { openWhatsApp } from "@/utils/utils";
import { MaterialIcons } from "@expo/vector-icons";
import { useLocalSearchParams, useRouter } from "expo-router";
import { useEffect, useState } from "react";
import { ActivityIndicator, FlatList, Image, ImageBackground, Modal, Platform, ScrollView, Text, TouchableOpacity, View } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";
import * as WebBrowser from "expo-web-browser";

declare global {
  interface Window {
    snap: any;
  }
}

export default function BookingDetail() {
  const auth = useAuth();
  const router = useRouter();
  const { id } = useLocalSearchParams();
  const [data, setData] = useState<BookingResponse | null>(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [modalVisible, setModalVisible] = useState(false);
  const [selectedMethod, setSelectedMethod] = useState(0);

  const metodePembelian = [
    { namaMetode: "KPR", icon: "house" },
    { namaMetode: "Tunai", icon: "attach-money" },
  ];

  const handlePayment = async () => {
    if (data?.data.status == "aktif") {
      try {
        const res = await api.post("/midtrans/token", {
          booking_id: id,
          amount: data?.data.cost,
          metode_pembelian: metodePembelian[selectedMethod].namaMetode,
        });

        const snapToken = res.data.token;

        if (Platform.OS === "web") {
          const script = document.createElement("script");
          script.src = "https://app.sandbox.midtrans.com/snap/snap.js";
          script.setAttribute("data-client-key", "SB-Mid-client-zthMNUvTPPD9piIs"); // ganti dengan key kamu
          document.body.appendChild(script);

          script.onload = () => {
            window.snap.pay(snapToken, {
              onSuccess: function (result: any) {
                console.log("Payment success:", result);
                router.push({ pathname: "/(protected)/payments/[id]", params: { id: res.data.paymentId } });
              },
            });
          };
        } else {
          const snapUrl = `https://app.sandbox.midtrans.com/snap/v2/vtweb/${snapToken}`;
          await WebBrowser.openBrowserAsync(snapUrl);
        }
      } catch (error) {
        console.error("Gagal generate Snap token", error);
      }
    } else {
      const res = await api.get(`/getPaymentId/${id}`);
      const data = await res.data;

      router.push({ pathname: "/(protected)/payments/[id]", params: { id: data.paymentId } });
    }
  };

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const res = await api.get(`bookings/${id}`);
        setData(res.data);
      } catch (e: any) {
        setError(e.message);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [id]);

  if (!auth) return null;
  if (loading || !data) return <ActivityIndicator />;
  if (error) return <Text style={{ color: "red" }}>{error}</Text>;

  return (
    <SafeAreaView style={{ flex: 1, padding: 16, paddingBottom: 100, backgroundColor: "white" }}>
      <ScrollView showsVerticalScrollIndicator={false}>
        <ImageBackground source={data.data.imageUrl} style={{ width: "100%", height: 320, padding: 16, borderRadius: 24, overflow: "hidden", alignItems: "flex-start" }} resizeMode="cover">
          <TouchableOpacity style={{ padding: 8, backgroundColor: "white", borderRadius: 50 }} onPress={() => router.back()}>
            <MaterialIcons name="arrow-back" size={24} />
          </TouchableOpacity>
        </ImageBackground>

        <View style={{ marginTop: 16, gap: 16 }}>
          <View style={{ flexDirection: "row", justifyContent: "space-between" }}>
            <View>
              <Text style={{ fontSize: 18, fontWeight: "bold" }}>{data.data.unitName}</Text>
              <Text style={{ color: "gray" }}>
                {data.data.blockName}, {data.data.typeName}
              </Text>
            </View>
            <Text style={{ fontSize: 16, fontWeight: "bold", color: "blue" }}>{data.data.price.toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
          </View>

          <View>
            <Text style={{ fontSize: 16, fontWeight: "500", marginBottom: 8 }}>Ringkasan booking</Text>
            <View style={{ flexDirection: "row", justifyContent: "space-between", borderBottomWidth: 1, borderColor: "#ccc", paddingBottom: 8 }}>
              <Text>Booking fee</Text>
              <Text>{data.data.cost.toLocaleString("id-ID", { style: "currency", currency: "IDR", maximumFractionDigits: 0 })}</Text>
            </View>
            <View style={{ flexDirection: "row", justifyContent: "space-between", borderBottomWidth: 1, borderColor: "#ccc", paddingVertical: 8 }}>
              <Text>Batas pembayaran</Text>
              <Text>{new Date(data.data.paymentDeadline).toLocaleDateString("id-ID", { dateStyle: "full" })}</Text>
            </View>
          </View>

          <View>
            <Text style={{ fontSize: 16, fontWeight: "500", marginBottom: 8 }}>Kontak marketing</Text>
            <View style={{ flexDirection: "row", alignItems: "center", gap: 8, backgroundColor: "#f1f1f1", padding: 8, borderRadius: 50 }}>
              <Image style={{ width: 48, height: 48, borderRadius: 50 }} source={data.data.marketingPhoto} />
              <View style={{ flex: 1 }}>
                <Text style={{ fontSize: 16, fontWeight: "500" }}>{data.data.marketingName}</Text>
                <Text style={{ color: "gray" }}>{data.data.marketingEmail}</Text>
              </View>
              <TouchableOpacity onPress={() => openWhatsApp(auth.user!, data.data.typeName, data.data.blockName, data.data.unitName, data.data.marketingPhone!)}>
                <Image style={{ width: 40, height: 40 }} source={require("@/assets/images/whatsapp-logo.png")} />
              </TouchableOpacity>
            </View>
          </View>

          <View>
            <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Metode pembelian</Text>
            <TouchableOpacity
              onPress={() => setModalVisible(true)}
              style={{
                paddingHorizontal: 20,
                paddingVertical: 12,
                backgroundColor: "#0061FF",
                borderRadius: 24,
                flexDirection: "row",
                justifyContent: "space-between",
              }}
            >
              <Text style={{ color: "white" }}>{metodePembelian[selectedMethod].namaMetode}</Text>
              <MaterialIcons name={metodePembelian.at(selectedMethod)?.icon} size={20} color="white" />
            </TouchableOpacity>
          </View>
        </View>
      </ScrollView>

      <View
        style={{
          position: "absolute",
          bottom: 0,
          left: 0,
          right: 0,
          backgroundColor: "white",
          borderTopLeftRadius: 32,
          borderTopRightRadius: 32,
          borderTopWidth: 1,
          borderColor: "#ccc",
          padding: 16,
          flexDirection: "row",
          justifyContent: "space-between",
          alignItems: "center",
        }}
      >
        <View>
          <Text style={{ fontSize: 18, fontWeight: "bold" }}>Booking Fee</Text>
          <Text style={{ fontSize: 16, fontWeight: "bold", color: "blue" }}>{(500_000).toLocaleString("id-ID", { style: "currency", currency: "IDR" })}</Text>
        </View>
        <TouchableOpacity onPress={handlePayment} style={{ backgroundColor: "blue", paddingVertical: 10, paddingHorizontal: 20, borderRadius: 24 }}>
          <Text style={{ color: "white", fontWeight: "bold" }}>{data.data.status == "aktif" ? "Bayar booking fee" : "Lihat detail pembayaran"}</Text>
        </TouchableOpacity>
      </View>

      <Modal visible={modalVisible} transparent animationType="slide" onRequestClose={() => setModalVisible(false)}>
        <View style={{ flex: 1, backgroundColor: "rgba(0,0,0,0.5)", justifyContent: "center", padding: 20 }}>
          <View style={{ backgroundColor: "white", borderRadius: 10, padding: 20 }}>
            <Text style={{ fontSize: 18, fontWeight: "bold", marginBottom: 10 }}>Pilih Metode Pembayaran</Text>
            <FlatList
              data={metodePembelian}
              keyExtractor={(_, index) => index.toString()}
              renderItem={({ item, index }) => (
                <TouchableOpacity
                  onPress={() => {
                    setSelectedMethod(index);
                    setModalVisible(false);
                  }}
                  style={{ flexDirection: "row", alignItems: "center", paddingVertical: 12, borderBottomWidth: 1, borderBottomColor: "#eee" }}
                >
                  <MaterialIcons name={item.icon} size={20} color="#333" style={{ marginRight: 10 }} />
                  <Text style={{ flex: 1 }}>{item.namaMetode}</Text>
                  <MaterialIcons name={selectedMethod === index ? "check-box" : "check-box-outline-blank"} size={20} color={selectedMethod === index ? "#0061FF" : "#aaa"} />
                </TouchableOpacity>
              )}
            />
            <TouchableOpacity onPress={() => setModalVisible(false)} style={{ marginTop: 15, backgroundColor: "#777", paddingVertical: 10, borderRadius: 5, alignItems: "center" }}>
              <Text style={{ color: "white" }}>Batal</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
    </SafeAreaView>
  );
}
