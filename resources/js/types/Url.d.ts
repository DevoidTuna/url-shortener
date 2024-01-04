interface Url {
  id?: number;
  user_id?: number;
  shortened_link?: string;
  recipient_link?: string;
  expired_at?: number | string | null;
  public?: number;
  deleted_at?: string | null;
  created_at?: string;
  updated_at?: string;
}

export { Url };
