import { useEffect, useMemo, useState } from "react";
import Table from "../../Components/Table";
import "./Home.css";
import type { User } from "../../Models";
import { getUsers } from "../../Services/userServices";

export default function Home() {
  const [users, setUsers] = useState<User[]>([]);
  const [queryName, setQueryName] = useState("");
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const controller = new AbortController();

    async function load() {
      try {
        setLoading(true);
        setError(null);
        const data = await getUsers(controller.signal);
        setUsers(data);
      } catch (error: any) {
        if (error?.name !== "AbortError")
          setError(error?.message ?? "Bir hata oluştu");
      } finally {
        setLoading(false);
      }
    }

    load();
    return () => controller.abort();
  }, []);

  const filteredUsers = useMemo(() => {
    const query = queryName.trim().toLowerCase();
    if (!query) return users;
    return users.filter((u) => u.name.toLowerCase().includes(query));
  }, [users, queryName]);

  return (
    <>
      <section className="home">
        <header>
          <p>Manage your data from a single dashboard</p>
          <h3>Product Listing</h3>
          <p>
            You can list your products, apply filters, and easily view
            up-to-date information.
            <br />
            The listing screen is designed to provide quick access to product
            details and simplify data tracking.
          </p>
        </header>
        {loading && <p>Loading...</p>}
        {error && <p>Hata: {error}</p>}

        {!loading && !error && (
          <Table
            data={filteredUsers}
            query={queryName}
            onChange={setQueryName}
          />
        )}
      </section>
    </>
  );
}
