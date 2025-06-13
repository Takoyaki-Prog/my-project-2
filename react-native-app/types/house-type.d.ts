import type { Facility, HouseUnit, HouseUnitGalery } from "@/types/index.";

export interface HouseTypeResponse {
  success: boolean;
  message: string;
  data: {
    id: number;
    imageUrl: any;
    name: string;
    summary: string;
    price: number;
    facilities: Facility[];
    units: HouseUnit[];
    galleries: HouseUnitGalery[];
  };
}
