import type { Block } from "@/types/index.";
import { Text, TouchableOpacity } from "react-native";

export default function BlockItem({ item, selectedBlock, setSelectedBlock }: { item: Block; selectedBlock: number; setSelectedBlock: (blockId: number) => void }) {
  return (
    <TouchableOpacity style={[{ paddingInline: 16, paddingBlock: 8, backgroundColor: "white", borderWidth: 1, borderColor: "lightgray", borderRadius: 50 }, selectedBlock === item.id && { backgroundColor: "blue", borderColor: "blue" }]} onPress={() => setSelectedBlock(item.id)}>
      <Text style={selectedBlock === item.id && { fontWeight: "500", color: "white" }}>{item.name}</Text>
    </TouchableOpacity>
  );
}
