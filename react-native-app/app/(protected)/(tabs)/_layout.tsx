import { MaterialIcons } from "@expo/vector-icons";
import { Tabs } from "expo-router";

export default function TabLayout() {
  return (
    <Tabs screenOptions={{ headerShown: false }}>
      <Tabs.Screen name="index" options={{ title: "Beranda", tabBarIcon: ({ size, color }) => <MaterialIcons name="home" size={size} color={color} /> }} />
      <Tabs.Screen name="list-bookings" options={{ title: "Booking", tabBarIcon: ({ size, color }) => <MaterialIcons name="book-online" size={size} color={color} /> }} />
      <Tabs.Screen name="settings" options={{ title: "Pengaturan", tabBarIcon: ({ size, color }) => <MaterialIcons name="settings" size={size} color={color} /> }} />
    </Tabs>
  );
}
