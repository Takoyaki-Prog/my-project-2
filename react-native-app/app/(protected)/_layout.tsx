import { useAuth } from "@/context/AuthContext";
import { Redirect, Stack } from "expo-router";

export default function ProtectedLayout() {
  const auth = useAuth();

  if (!auth) return null;

  if (!auth.token) return <Redirect href={"/(auth)/login"} />;

  return (
    <Stack screenOptions={{ headerShown: false }}>
      <Stack.Screen name="(tabs)" />
      <Stack.Screen name="bookings" />
      <Stack.Screen name="house-types" />
    </Stack>
  );
}
