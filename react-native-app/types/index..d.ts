export interface HouseType {
  id: number;
  imageUrl: any;
  name: string;
  summary: string;
  price: number;
}

export interface BlockHouseUnits {
  id: number;
  name: string;
  latitude: number;
  longtitude: number;
}

export interface HouseUnit {
  id: number;
  imageUrl: any;
  name: string;
  block?: BlockHouseUnits;
  houseType?: HouseType;
  marketing?: User;
}

export interface Facility {
  id: number;
  imageUrl: any;
  name: string;
  description: string;
}

export interface HouseTypeGalery {
  id: number;
  imageUrl: any;
  name: string;
  description: string;
}

export interface HouseUnitGalery {
  id: number;
  imageUrl: any;
  name: string;
  description: string;
}

export interface Booking {
  id: number;
  cost: number;
  paymentDeadline: Date;
  status: "aktif" | "dibayar" | "selesai" | "dibatalkan";
  unit: HouseUnit;
}

export interface Setting {
  icon: any;
  name: string;
  href: string;
}

export interface Payment {
  id: number;
  amount: number;
  status: "tertunda" | "berhasil" | "gagal";
  booking: Booking;
}
