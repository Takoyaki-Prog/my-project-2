import type { BlockHouseUnits, HouseType, HouseUnit } from "@/types/index.";

export interface HomeResponse {
  success: boolean;
  message: string;
  data: {
    blockHouseUnits: BlockHouseUnits[];
    houseTypes: HouseType[];
    houseUnits: HouseUnit[];
  };
}
