import { User } from "./auth";
import { BlockHouseUnits, Facility, HouseUnitGalery } from "./index.";

export interface HouseUnitResponse {
  success: boolean;
  message: string;
  data: {
    id: number;
    name: string;
    imageUrl: any;
    summary: string;
    price: number;
    typeName: string;
    status: string;
    block: BlockHouseUnits;
    facilities: Facility[];
    marketing: User;
    galleries: HouseUnitGalery[];
  };
}
