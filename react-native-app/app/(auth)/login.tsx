import { useAuth } from "@/context/AuthContext";
import { MaterialIcons } from "@expo/vector-icons";
import { Link } from "expo-router";
import { useState } from "react";
import { Image, Text, TextInput, TouchableOpacity, View } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

export default function Login() {
  const auth = useAuth();
  const [inputEmail, setInputEmail] = useState("");
  const [inputPassword, setInputPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState<any>({});

  if (!auth) return null;

  const handleLogin = async () => {
    setLoading(true);
    const res = await auth.login(inputEmail, inputPassword);
    if (!res.success) {
      setErrors(res.errors);
    }
    setLoading(true);
  };

  return (
    <SafeAreaView style={{ flex: 1, justifyContent: "center", padding: 20, backgroundColor: "white" }}>
      {/* Logo */}
      <View style={{ alignItems: "center", marginBottom: 12 }}>
        <Image style={{ width: 260, height: 260 }} source={require("@/assets/images/logo.png")} resizeMode="contain" />
      </View>

      {/* Heading */}
      <Text style={{ marginBottom: 24, color: "#191D31", fontSize: 20, fontWeight: "bold" }}>Masuk Akun</Text>

      <View style={{ gap: 16 }}>
        {/* Input email */}
        <View>
          <Text style={{ marginBottom: 6, fontSize: 14, fontWeight: "500", color: "#333" }}>Alamat Email</Text>
          <View style={{ flexDirection: "row", backgroundColor: "#FBFBFD", borderWidth: 1, borderColor: "#0061FF1A", borderRadius: 6, alignItems: "center" }}>
            <MaterialIcons style={{ paddingHorizontal: 12 }} name="email" size={24} color={"#8C8E98"} />
            <TextInput style={{ flex: 1, paddingVertical: 10, paddingHorizontal: 8, fontSize: 14, color: "#222" }} placeholder="Masukkan email terdaftar" placeholderTextColor={"#8C8E98"} keyboardType="email-address" autoCapitalize="none" value={inputEmail} onChangeText={setInputEmail} />
          </View>
          {errors.email && <Text style={{ color: "red" }}>{errors.email[0]}</Text>}
        </View>

        {/* Input password */}
        <View>
          <Text style={{ marginBottom: 6, fontSize: 14, fontWeight: "500", color: "#333" }}>Kata Sandi</Text>
          <View style={{ flexDirection: "row", backgroundColor: "#FBFBFD", borderWidth: 1, borderColor: "#0061FF1A", borderRadius: 6, alignItems: "center" }}>
            <MaterialIcons style={{ paddingHorizontal: 12 }} name="key" size={24} color={"#8C8E98"} />
            <TextInput style={{ flex: 1, paddingVertical: 10, paddingHorizontal: 8, fontSize: 14, color: "#222" }} placeholder="Masukkan kata sandi Anda" placeholderTextColor={"#8C8E98"} autoCapitalize="none" secureTextEntry value={inputPassword} onChangeText={setInputPassword} />
          </View>
          {errors.password && <Text style={{ color: "red" }}>{errors.password[0]}</Text>}
        </View>

        {/* Tombol login */}
        <TouchableOpacity style={{ padding: 12, backgroundColor: "#0061FF", borderRadius: 24 }} onPress={handleLogin} disabled={loading}>
          <Text style={{ color: "#FFFFFF", fontSize: 16, fontWeight: "600", textAlign: "center" }}>{loading ? "Sedang mencoba masuk..." : "Masuk"}</Text>
        </TouchableOpacity>

        {/* Link ke halaman register */}
        <Link style={{ color: "#0061FF", fontSize: 14, fontWeight: "500", textAlign: "center", textDecorationLine: "underline" }} href={"/(auth)/register"}>
          Belum punya akun? Daftar aja.
        </Link>
      </View>
    </SafeAreaView>
  );
}
