import { MongoClient } from 'mongodb';

(async () => {
  const uri = process.env.MONGO_URI || 'mongodb://localhost:27017/myapp_mileapp'
  const client = new MongoClient(uri)
  await client.connect()
  const db = client.db()
  const tasks = db.collection('tasks')

  await tasks.createIndex({ status: 1 })
  await tasks.createIndex({ priority: -1 })
  await tasks.createIndex({ title: 'text' })

  console.log('MongoDB indexes created successfully.')
  await client.close()
})()
