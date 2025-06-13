export interface User {
  id: number;
  photoUrl: any;
  name: string;
  email: string;
  phone?: string;
  role?: "admin" | "marketing" | "customer";
}
