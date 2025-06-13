import api from "@/api/api";
import BookingItem from "@/components/BookingItem";
import { useAuth } from "@/context/AuthContext";
import { ListBookingResponse } from "@/types/booking";
import { useEffect, useState } from "react";
import { ActivityIndicator, FlatList, Text } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

export default function Booking() {
  const auth = useAuth();
  const [data, setData] = useState<ListBookingResponse | null>(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  if (!auth) return null;

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        const res = await api.get("bookings");
        const data = await res.data;
        setData(data);
      } catch (e: any) {
        setError(e.message);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [auth]);

  if (loading || !data) return <ActivityIndicator />;

  if (error) return <Text style={{ color: "red" }}>{error}</Text>;

  return (
    <SafeAreaView style={{ flex: 1, padding: 16, backgroundColor: "white" }}>
      <Text style={{ marginBottom: 8, fontSize: 16, fontWeight: "500" }}>Daftar booking</Text>
      <FlatList showsVerticalScrollIndicator={false} contentContainerStyle={{ gap: 12 }} data={data.data} keyExtractor={(_, index) => index.toString()} renderItem={({ item }) => <BookingItem item={item} />} />
    </SafeAreaView>
  );
}
